<?php
class Animal
{
    private $id;
    private $nom;
    private $espece;
    private $alimentation;
    private $image;
    private $paysorigine;
    private $descriptioncourte;
    private $id_habitat;

    public function __construct($id, $nom, $espece, $alimentation, $image, $paysorigine, $descriptioncourte, $id_habitat)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->espece = $espece;
        $this->alimentation = $alimentation;
        $this->image = $image;
        $this->paysorigine = $paysorigine;
        $this->descriptioncourte = $descriptioncourte;
        $this->id_habitat = $id_habitat;
    }

    public function get_id()
    {
        return $this->id;
    }
    public function get_nom()
    {
        return $this->nom;
    }
    public function get_espece()
    {
        return $this->espece;
    }
    public function get_alimentation()
    {
        return $this->alimentation;
    }
    public function get_image()
    {
        return $this->image;
    }
    public function get_paysorigine()
    {
        return $this->paysorigine;
    }
    public function get_descriptioncourte()
    {
        return $this->descriptioncourte;
    }
    public function get_id_habitat()
    {
        return $this->id_habitat;
    }
    public static function find_all_animaux($conn)
    {
        $stmt = $conn->prepare("SELECT * FROM animaux");
        $stmt->execute();
        $liste_animaux = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $animal = new Animal(
                $row['id_animal'],
                $row['nom'],
                $row['espèce'],
                $row['alimentation'],
                $row['image'],
                $row['paysorigine'],
                $row['descriptioncourte'],
                $row['id_habitat']
            );
            $liste_animaux[] = $animal;
        }
        return $liste_animaux;
    }
    public static function stats_animaux($conn)
    {
        $stmt = $conn->query("SELECT COUNT(*) FROM animaux");
        return $stmt->fetchColumn();
    }

    public static function ajouter_animal($conn, $nom, $espèce, $alimentation, $image,$paysorigine,$descriptioncourte,$id_habitat)
    {
        $sql_verif = "SELECT COUNT(*) FROM animaux WHERE LOWER(nom) = LOWER(?)";
        $stmt_verif = $conn->prepare($sql_verif);
        $stmt_verif->execute([$nom]);

        if ($stmt_verif->fetchColumn() > 0) {
            return false;
        }

        $sql = "INSERT INTO animaux (nom,espèce,alimentation,image,paysorigine,descriptioncourte,id_habitat) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([$nom, $espèce, $alimentation, $image, $paysorigine, $descriptioncourte,$id_habitat]);
    }
}
?>