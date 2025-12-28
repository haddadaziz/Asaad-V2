<?php
session_start();
require_once 'config.php';
require_once 'classes/visite.php';

$database = new Database();
$conn = $database->getConnection();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'guide') {
    header("Location: login.php"); exit();
}

$id_guide = $_SESSION['user_id'];
$section = isset($_GET['section']) ? $_GET['section'] : 'mes_visites';

if (isset($_POST['creer_visite'])) {
    $dateheure = $_POST['date'] . ' ' . $_POST['heure'] . ':00';
    
    Visite::creerVisite(
        $conn, 
        $_POST['titre'], 
        $dateheure, 
        (int)$_POST['duree'], 
        $_POST['langue'], 
        (float)$_POST['prix'], 
        (int)$_POST['capacite'], 
        $id_guide
    );
    header("Location: ?section=mes_visites&status=success_creation_visite"); 
    exit();
}
$mes_visites = Visite::getVisitesByGuide($conn, $id_guide);
$mes_reservations = Visite::getReservationsByGuide($conn, $id_guide);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Espace Guide - Zoo Assad</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="script.js?v=<?= time() ?>" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: { extend: { colors: { 'maroc-red': '#C1272D', 'maroc-green': '#006233' }, fontFamily: { 'headings': ['Montserrat', 'sans-serif'] } } }
        }
    </script>
</head>

<body class="bg-gray-50 font-sans flex h-screen overflow-hidden">

    <aside class="w-64 bg-maroc-green text-white flex flex-col shadow-2xl">
        <div class="h-20 flex items-center justify-center border-b border-green-800 bg-green-900">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-compass text-yellow-400 text-2xl"></i>
                <span class="font-headings font-bold text-xl tracking-wider">ESPACE GUIDE</span>
            </div>
        </div>
        <div class="p-4 border-b border-green-700 bg-green-800">
            <p class="text-xs text-green-200 uppercase">Bienvenue,</p>
            <p class="font-bold truncate"><?= htmlspecialchars($_SESSION['nom']) ?></p>
        </div>
        <nav class="flex-1 overflow-y-auto py-6">
            <ul class="space-y-2">
                <li>
                    <a href="?section=mes_visites" class="flex items-center px-6 py-3 hover:bg-green-700 transition <?= $section == 'mes_visites' ? 'bg-green-900 border-l-4 border-yellow-400' : '' ?>">
                        <i class="fa-solid fa-map-location-dot w-6"></i> <span class="font-medium ml-2">Mes Visites</span>
                    </a>
                </li>
                <li>
                    <a href="?section=reservations" class="flex items-center px-6 py-3 hover:bg-green-700 transition <?= $section == 'reservations' ? 'bg-green-900 border-l-4 border-yellow-400' : '' ?>">
                        <i class="fa-solid fa-clipboard-list w-6"></i> <span class="font-medium ml-2">Réservations</span>
                    </a>
                </li>
            </ul>
        </nav>
        <div class="p-4 border-t border-green-700">
            <a href="logout.php" class="flex items-center gap-2 text-green-200 hover:text-white transition"><i class="fa-solid fa-right-from-bracket"></i> Déconnexion</a>
        </div>
    </aside>

    <main class="flex-1 overflow-y-auto p-8">
        <header class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-headings font-bold text-gray-800">
                <?= ($section == 'mes_visites') ? "Gestion des Visites" : "Liste des Réservations" ?>
            </h1>
            <a href="index.php" class="text-gray-500 hover:text-maroc-red text-sm flex items-center gap-2"><i class="fa-solid fa-home"></i> Retour au site</a>
        </header>

        <?php if ($section == 'mes_visites'): ?>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="bg-white p-6 rounded-xl shadow-md border-t-4 border-maroc-red h-fit">
                    <h2 class="font-bold text-lg mb-4 text-gray-700"><i class="fa-solid fa-plus-circle mr-2"></i>Créer une visite</h2>
                    <form method="POST" action="">
                        <div class="space-y-4">
                            <div><label class="block text-xs font-bold text-gray-500 uppercase mb-1">Titre</label><input type="text" name="titre" required class="w-full border p-2 rounded focus:ring-1 focus:ring-maroc-green"></div>
                            <div class="grid grid-cols-2 gap-3">
                                <div><label class="block text-xs font-bold text-gray-500 uppercase mb-1">Date</label><input type="date" name="date" required class="w-full border p-2 rounded text-sm"></div>
                                <div><label class="block text-xs font-bold text-gray-500 uppercase mb-1">Heure</label><input type="time" name="heure" required class="w-full border p-2 rounded text-sm"></div>
                            </div>
                            <div><label class="block text-xs font-bold text-gray-500 uppercase mb-1">Langue</label>
                                <select name="langue" class="w-full border p-2 rounded"><option>Français</option><option>Arabe</option><option>Anglais</option></select>
                            </div>
                            <div class="grid grid-cols-3 gap-3">
                                <div><label class="block text-xs font-bold text-gray-500 uppercase mb-1">Durée</label><input type="number" name="duree" value="90" class="w-full border p-2 rounded"></div>
                                <div><label class="block text-xs font-bold text-gray-500 uppercase mb-1">Prix</label><input type="number" name="prix" value="100" class="w-full border p-2 rounded"></div>
                                <div><label class="block text-xs font-bold text-gray-500 uppercase mb-1">Max</label><input type="number" name="capacite" value="15" class="w-full border p-2 rounded"></div>
                            </div>
                            <button type="submit" name="creer_visite" class="w-full bg-maroc-green hover:bg-green-800 text-white font-bold py-3 rounded transition shadow-md">Publier</button>
                        </div>
                    </form>
                </div>

                <div class="lg:col-span-2 space-y-4">
                    <h2 class="font-bold text-lg text-gray-700">Mes Visites Actives</h2>
                    <?php if (empty($mes_visites)): ?>
                        <div class="bg-white p-8 rounded-xl shadow text-center text-gray-500">Aucune visite.</div>
                    <?php else: ?>
                        <?php foreach ($mes_visites as $v): ?>
                            <div class="bg-white rounded-xl shadow p-5 border-l-4 border-maroc-green flex justify-between items-center">
                                <div>
                                    <h3 class="font-bold text-lg text-gray-800"><?= $v->getTitre() ?></h3>
                                    <div class="text-sm text-gray-500 mt-1">
                                        <i class="fa-regular fa-calendar mr-1"></i> <?= date('d/m/Y H:i', strtotime($v->getDateHeure())) ?>
                                        <span class="mx-2">|</span> 
                                        <i class="fa-solid fa-language mr-1"></i> <?= $v->getLangue() ?>
                                    </div>
                                </div>
                                
                                <?php $rest = Visite::getPlacesRestantes($conn, $v->getId(), $v->getCapacite()); ?>
                                
                                <div class="text-right">
                                    <div class="text-2xl font-bold <?= $rest == 0 ? 'text-red-500' : 'text-maroc-green' ?>">
                                        <?= $v->getCapacite() - $rest ?> / <?= $v->getCapacite() ?>
                                    </div>
                                    <div class="text-xs text-gray-400 font-bold uppercase">Réservations</div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

        <?php elseif ($section == 'reservations'): ?>
            
            <div class="bg-white rounded-xl shadow overflow-hidden">
                <?php if (empty($mes_reservations)): ?>
                    <div class="p-10 text-center text-gray-500">Aucune réservation trouvée.</div>
                <?php else: ?>
                    <table class="w-full text-left">
                        <thead class="bg-gray-100 text-gray-600 uppercase text-xs font-bold">
                            <tr>
                                <th class="p-4">Nom Client</th>
                                <th class="p-4">Visite Concernée</th>
                                <th class="p-4 text-center">Places</th>
                                <th class="p-4">Date Résa.</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-gray-100">
                            <?php foreach ($mes_reservations as $res): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="p-4">
                                        <div class="font-bold text-gray-800"><?= $res['nom'] ?></div>
                                        <div class="text-xs text-gray-500"><?= $res['email'] ?></div>
                                    </td>
                                    <td class="p-4">
                                        <div class="font-semibold text-maroc-green"><?= $res['titre'] ?></div>
                                        <div class="text-xs text-gray-500"><?= date('d/m/Y H:i', strtotime($res['dateheure'])) ?></div>
                                    </td>
                                    <td class="p-4 text-center">
                                        <span class="bg-blue-100 text-blue-800 font-bold px-3 py-1 rounded-full text-xs">
                                            <?= $res['nb_places'] ?> pers.
                                        </span>
                                    </td>
                                    <td class="p-4 text-gray-500"><?= date('d/m/Y', strtotime($res['date_reservation'])) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>

        <?php endif; ?>

    </main>

    <div id="success_notification" class="hidden fixed top-6 left-1/2 transform -translate-x-1/2 z-[999] bg-green-500 text-white px-10 py-4 rounded-full shadow-2xl"></div>
    <div id="error_notification" class="hidden fixed top-6 left-1/2 transform -translate-x-1/2 z-[999] bg-red-500 text-white px-10 py-4 rounded-full shadow-2xl"></div>

</body>
</html>