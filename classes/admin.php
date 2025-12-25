<?php
class Admin extends User
{
    public static function activer_compte($conn, $id_user)
    {
        $stmt = $conn->prepare("UPDATE utilisateurs SET statut = 1 WHERE id_utilisateur = ?");
        $stmt->execute([$id_user]);
    }

    public static function bloquer_compte($conn, $id_user)
    {
        $stmt = $conn->prepare("UPDATE utilisateurs SET statut = 0 WHERE id_utilisateur = ?");
        $stmt->execute([$id_user]);
    }
}
?>