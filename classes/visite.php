<?php
class Visite{
    public static function stats_visite($conn){
        $stmt = $conn->query("SELECT COUNT (*) FROM visitesguidees");
        return $stmt->fetchColumn();
    }
}
?>