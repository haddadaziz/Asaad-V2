<?php
class User
{
    private $id;
    private $nom;
    private $email;
    private $role;
    private $hashed_password;
    private $statut;

    public function __construct($id, $nom, $email, $role, $hashed_password, $statut)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->email = $email;
        $this->role = $role;
        $this->hashed_password = $hashed_password;
        $this->statut = $statut;
    }
    public function get_id()
    {
        return $this->id;
    }
    public function get_nom()
    {
        return $this->nom;
    }
    public function get_email()
    {
        return $this->email;
    }
    public function get_role()
    {
        return $this->role;
    }
    public function get_statut()
    {
        return $this->statut;
    }
    public static function verifier_login($conn, $email, $password)
    {
        $stmt = $conn->prepare("SELECT * FROM utilisateurs WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['motpasse_hash'])) {
            if ($user['statut'] == 0) {
                header("Location: login.php?status=pending_registration");
                return null;
            }
            return new User(
                $user['id_utilisateur'],
                $user['nom'],
                $user['email'],
                $user['role'],
                $user['motpasse_hash'],
                $user['statut']
            );
        }
        return null;
    }
    public static function find_all_users($conn)
    {
        $stmt = $conn->prepare("SELECT * FROM utilisateurs");
        $stmt->execute();
        $liste_utilisateurs = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $user = new User(
                $row['id_utilisateur'],
                $row['nom'],
                $row['email'],
                $row['role'],
                $row['motpasse_hash'],
                $row['statut'],
            );
            $liste_utilisateurs[] = $user;
        }
        return $liste_utilisateurs;
    }
    public static function stats_visiteurs($conn) {
        $stmt = $conn->prepare("SELECT COUNT(*) FROM utilisateurs WHERE role = 'visiteur'");
        $stmt->execute();
        return $stmt->fetchColumn();
    }
}
?>