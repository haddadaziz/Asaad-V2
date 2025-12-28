<?php
class Animal {
    private $id;
    private $nom;
    private $espece;
    private $alimentation;
    private $image;
    private $paysorigine;
    private $descriptioncourte;
    private $id_habitat;

    public function __construct() { }

    public function getId() { return $this->id; }
    public function getNom() { return $this->nom; }
    public function getEspece() { return $this->espece; }
    public function getAlimentation() { return $this->alimentation; }
    public function getImage() { return $this->image; }

    public function get_pays_origine() { return $this->paysorigine; } 
    
    public function get_description_courte() { return $this->descriptioncourte; }
    
    public function get_nom_habitat($conn) {
        if(empty($this->id_habitat)) return "Non défini";
        $stmt = $conn->prepare("SELECT nom FROM habitats WHERE id_habitat = ?");
        $stmt->execute([$this->id_habitat]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return $res ? $res['nom'] : "Inconnu";
    }

    public static function filtrer_animaux($conn, $habitat, $pays) {
        
        if (!empty($habitat) && !empty($pays)) {
            $sql = "SELECT * FROM animaux WHERE id_habitat = ? AND paysorigine = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$habitat, $pays]);
        }
        else if (!empty($habitat)) {
            $sql = "SELECT * FROM animaux WHERE id_habitat = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$habitat]);
        }
        else if (!empty($pays)) {
            $sql = "SELECT * FROM animaux WHERE paysorigine = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$pays]);
        }
        else {
            $sql = "SELECT * FROM animaux";
            $stmt = $conn->query($sql);
            return $stmt->fetchAll(PDO::FETCH_CLASS, 'Animal');
        }

        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Animal');
    }

    public static function find_all_animaux($conn) {
        $sql = "SELECT * FROM animaux";
        $stmt = $conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Animal');
    }
        public static function ajouter_animal($conn, $nom, $espece, $alimentation, $image, $pays, $desc, $id_habitat) {
        $sql = "INSERT INTO animaux (nom, espece, alimentation, image, paysorigine, descriptioncourte, id_habitat) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([$nom, $espece, $alimentation, $image, $pays, $desc, $id_habitat]);
    }
}
?>