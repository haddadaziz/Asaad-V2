<?php
class Visite
{
    private $id_visite;
    private $titre;
    private $dateheure;
    private $langue;
    private $capacite_max;
    private $statut;
    private $duree;
    private $prix;
    private $id_guide;

    public function __construct()
    {
    }
    public function getId()
    {
        return $this->id_visite;
    }
    public function getTitre()
    {
        return $this->titre;
    }
    public function getDateHeure()
    {
        return $this->dateheure;
    }
    public function getDuree()
    {
        return $this->duree;
    }
    public function getLangue()
    {
        return $this->langue;
    }
    public function getPrix()
    {
        return $this->prix;
    }
    public function getCapacite()
    {
        return $this->capacite_max;
    }
    public function getStatut()
    {
        return $this->statut;
    }
    public function getIdGuide()
    {
        return $this->id_guide;
    }

    public function estPassee()
    {
        return strtotime($this->dateheure) < time();
    }

    public static function creerVisite($conn, $titre, $dateheure, $duree, $langue, $prix, $capacite, $id_guide)
    {
        $sql = "INSERT INTO visitesguidees (titre, dateheure, duree, langue, prix, capacite_max, statut, id_guide) 
                VALUES (?, ?, ?, ?, ?, ?, 'active', ?)";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([$titre, $dateheure, $duree, $langue, $prix, $capacite, $id_guide]);
    }

    public static function getVisitesByGuide($conn, $id_guide)
    {
        $sql = "SELECT * FROM visitesguidees WHERE id_guide = ? ORDER BY dateheure DESC";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id_guide]);
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Visite');
    }
    public static function find_visites_futures($conn, $recherche = "")
    {
        $terme = "%" . $recherche . "%";
        $sql = "SELECT * FROM visitesguidees WHERE dateheure > NOW() AND statut = 'active' AND titre LIKE ? ORDER BY dateheure ASC";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$terme]);
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Visite');
    }
    public static function getReservationsByGuide($conn, $id_guide)
    {
        $sql = "SELECT r.datereservation AS date_reservation, r.nbpersonnes AS nb_places, v.titre, v.dateheure, u.nom, u.email 
                FROM reservations r
                JOIN visitesguidees v ON r.idvisite = v.id_visite
                JOIN utilisateurs u ON r.idutilisateur = u.id_utilisateur  
                WHERE v.id_guide = ? 
                ORDER BY r.datereservation DESC";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id_guide]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function getPlacesRestantes($conn, $id_visite, $capacite_max)
    {
        $sql = "SELECT SUM(nbpersonnes) as total FROM reservations WHERE idvisite = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id_visite]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);

        $places_prises = $res['total'] ?? 0;
        return $capacite_max - $places_prises;
    }

    public static function ajouterReservation($conn, $id_visite, $id_user, $nb_places)
    {
        $sql = "INSERT INTO reservations (idvisite, idutilisateur, nbpersonnes, datereservation) 
                VALUES (?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([$id_visite, $id_user, $nb_places]);
    }

    public static function getVisiteById($conn, $id)
    {
        $stmt = $conn->prepare("SELECT * FROM visitesguidees WHERE id_visite = ?");
        $stmt->execute([$id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Visite');
        return $stmt->fetch();
    }
}
?>