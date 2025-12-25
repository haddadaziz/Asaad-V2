<?php
class Habitat
{
    private $id_habitat;
    private $nom;
    private $typeclimat;
    private $description;
    private $zonezoo;

    public function __construct($id, $nom, $typeclimat, $description, $zonezoo)
    {
        $this->id_habitat = $id;
        $this->nom = $nom;
        $this->typeclimat = $typeclimat;
        $this->description = $description;
        $this->zonezoo = $zonezoo;
    }

    public function get_id()
    {
        return $this->id_habitat;
    }
    public function get_nom()
    {
        return $this->nom;
    }
    public function get_typeclimat()
    {
        return $this->typeclimat;
    }
    public function get_description()
    {
        return $this->description;
    }
    public function get_zonezoo()
    {
        return $this->zonezoo;
    }

    public static function ajouter_habitat($conn, $nom, $typeclimat, $description, $zonezoo)
    {
        $sql_verif = "SELECT COUNT(*) FROM habitats WHERE LOWER(nom) = LOWER(?)";
        $stmt_verif = $conn->prepare($sql_verif);
        $stmt_verif->execute([$nom]);

        if ($stmt_verif->fetchColumn() > 0) {
            return false;
        }

        $sql = "INSERT INTO habitats (nom,typeclimat,description,zonezoo) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([$nom, $typeclimat, $description, $zonezoo]);
    }

    public static function find_all_habitats($conn)
    {
        $stmt = $conn->prepare("SELECT * FROM habitats");
        $stmt->execute();
        $liste_habitats = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $habitat = new Habitat(
                $row['id_habitat'],
                $row['nom'],
                $row['typeclimat'],
                $row['description'],
                $row['zonezoo']
            );
            $liste_habitats[] = $habitat;
        }
        return $liste_habitats;
    }
    public static function stats_habitats($conn){
        $stmt = $conn->query("SELECT COUNT(*) FROM habitats");
        return $stmt->fetchColumn();
    }
}
?>