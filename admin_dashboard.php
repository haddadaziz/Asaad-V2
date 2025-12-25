<?php
session_start();
require_once 'config.php';
require_once 'classes/animal.php';
require_once 'classes/user.php';
require_once 'classes/admin.php';
require_once 'classes/habitat.php';
require_once 'classes/visite.php';

$database = new Database();
$conn = $database->getConnection();
$animaux = Animal::find_all_animaux($conn);

if (isset($_GET['action']) && isset($_GET['id'])) {
    $id_user = $_GET['id'];
    $action = $_GET['action'];

    if ($action == 'valider') {
        Admin::activer_compte($conn, $id_user);
        header("Location: ?section=utilisateurs&status=success_compte_valider");
        exit();
    }

    if ($action == 'bannir') {
        Admin::bloquer_compte($conn, $id_user);
        header("Location: ?section=utilisateurs&status=success_block_user");
        exit();
    }
}

if (isset($_POST['creer_habitat'])) {
    $nom = trim($_POST['nom']);
    $typeclimat = trim($_POST['typeclimat']);
    $zonezoo = $_POST['zonezoo'];
    $description = $_POST['description'];

    if (Habitat::ajouter_habitat($conn, $nom, $typeclimat, $description, $zonezoo)) {
        header("Location: ?section=habitats&status=success_ajout_habitat");
    } else {
        header("Location: ?section=habitats&status=error_habitat_exists");
    }
    exit();
}

if (isset($_POST['creer_animal'])) {
    $nom = trim($_POST['nom']);
    $espèce = trim($_POST['espece']);
    $paysorigine = trim($_POST['pays']);
    $alimentation = trim($_POST['alimentation']);
    $id_habitat = trim($_POST['id_habitat']);
    $descriptioncourte = $_POST['description'];
    $image = $_POST['image'];

    if (Animal::ajouter_animal($conn, $nom, $espèce, $alimentation, $image, $paysorigine, $descriptioncourte, $id_habitat)) {
        header("Location: ?section=animaux&status=success_ajout_animal");
    }
    exit();
}

if ($_SESSION['role'] !== 'admin') {
    header("Location: login.php?redirect=admin");
    exit();
}

$section = $_GET['section'] ?? 'dashboard';

$stats_visiteurs_inscrits = User::stats_visiteurs($conn);
$stats_animaux = Animal::stats_animaux($conn);
$stats_habitats = Habitat::stats_habitats($conn);
$stats = [
    'visiteurs' => $stats_visiteurs_inscrits,
    'animaux' => $stats_animaux,
    'visites' => 12,
    'habitats' => $stats_habitats
];

$habitats_list = Habitat::find_all_habitats($conn);
$animaux_list = Animal::find_all_animaux($conn);
$users_list = User::find_all_users(($conn));
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Zoo Assad</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="script.js" defer></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'maroc-red': '#C1272D',
                        'maroc-green': '#006233',
                    },
                    fontFamily: {
                        'headings': ['Montserrat', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gray-100 font-sans flex h-screen overflow-hidden">

    <aside class="w-64 bg-gray-900 text-white flex flex-col shadow-2xl">
        <div class="h-20 flex items-center justify-center border-b border-gray-800 bg-maroc-red">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-crown text-yellow-400 text-2xl"></i>
                <span class="font-headings font-bold text-xl tracking-wider">ADMIN ZOO</span>
            </div>
        </div>

        <nav class="flex-1 overflow-y-auto py-6">
            <ul class="space-y-2">
                <li>
                    <a href="?section=dashboard"
                        class="flex items-center px-6 py-3 hover:bg-gray-800 transition border-l-4 <?= $section == 'dashboard' ? 'border-maroc-red bg-gray-800' : 'border-transparent' ?>">
                        <i class="fa-solid fa-chart-line w-6"></i>
                        <span class="font-medium">Vue d'ensemble</span>
                    </a>
                </li>

                <li class="px-6 py-2 text-xs font-bold text-gray-500 uppercase mt-4">Gestion Contenu</li>

                <li>
                    <a href="?section=animaux"
                        class="flex items-center px-6 py-3 hover:bg-gray-800 transition border-l-4 <?= $section == 'animaux' ? 'border-maroc-red bg-gray-800' : 'border-transparent' ?>">
                        <i class="fa-solid fa-paw w-6"></i>
                        <span class="font-medium">Animaux</span>
                    </a>
                </li>

                <li>
                    <a href="?section=habitats"
                        class="flex items-center px-6 py-3 hover:bg-gray-800 transition border-l-4 <?= $section == 'habitats' ? 'border-maroc-red bg-gray-800' : 'border-transparent' ?>">
                        <i class="fa-solid fa-mountain-sun w-6"></i>
                        <span class="font-medium">Habitats</span>
                    </a>
                </li>

                <li class="px-6 py-2 text-xs font-bold text-gray-500 uppercase mt-4">Utilisateurs</li>

                <li>
                    <a href="?section=utilisateurs"
                        class="flex items-center px-6 py-3 hover:bg-gray-800 transition border-l-4 <?= $section == 'utilisateurs' ? 'border-maroc-red bg-gray-800' : 'border-transparent' ?>">
                        <i class="fa-solid fa-users w-6"></i>
                        <span class="font-medium">Gestion Des Utilisateurs</span>
                    </a>
                </li>
            </ul>
        </nav>

        <div class="p-4 border-t border-gray-800">
            <a href="logout.php" class="flex items-center gap-2 text-gray-400 hover:text-white transition">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span>Déconnexion</span>
            </a>
        </div>
    </aside>

    <main class="flex-1 overflow-y-auto bg-gray-100 p-8">

        <header class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-headings font-bold text-gray-800 capitalize">
                <?php
                if ($section == 'dashboard')
                    echo "Tableau de Bord";
                elseif ($section == 'animaux')
                    echo "Gestion des Animaux";
                elseif ($section == 'habitats')
                    echo "Gestion des Habitats";
                elseif ($section == 'utilisateurs')
                    echo "Gestion Des Utilisateurs";
                ?>
            </h1>
            <a href="index.php" target="_blank"
                class="bg-white text-gray-700 px-4 py-2 rounded shadow hover:bg-gray-50 flex items-center gap-2 text-sm">
                <i class="fa-solid fa-eye"></i> Voir le site
            </a>
        </header>
        <?php if ($section == 'dashboard'): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div
                    class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-maroc-red flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 font-bold uppercase">Visiteurs Inscrits</p>
                        <p class="text-3xl font-bold text-gray-800"><?= $stats['visiteurs'] ?></p>
                    </div>
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center text-maroc-red">
                        <i class="fa-solid fa-users text-xl"></i>
                    </div>
                </div>
                <div
                    class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-maroc-green flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 font-bold uppercase">Animaux</p>
                        <p class="text-3xl font-bold text-gray-800"><?= $stats['animaux'] ?></p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-maroc-green">
                        <i class="fa-solid fa-hippo text-xl"></i>
                    </div>
                </div>
                <div
                    class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-yellow-500 flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 font-bold uppercase">Visites Réservées</p>
                        <p class="text-3xl font-bold text-gray-800"><?= $stats['visites'] ?></p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center text-yellow-600">
                        <i class="fa-solid fa-ticket text-xl"></i>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-blue-500 flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 font-bold uppercase">Top Pays</p>
                        <p class="text-xl font-bold text-gray-800">Maroc 🇲🇦</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center text-blue-600">
                        <i class="fa-solid fa-globe text-xl"></i>
                    </div>
                </div>
            </div>


        <?php elseif ($section == 'animaux'): ?>
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="mb-8 p-6 bg-gray-50 rounded-lg border border-gray-200">
                    <h3 class="font-bold text-lg mb-4 text-maroc-green"><i class="fa-solid fa-plus-circle mr-2"></i>Ajouter
                        un nouvel animal</h3>
                    <form action="?section=animaux" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <input type="text" name="nom" placeholder="Nom (ex: Simba)" class="border p-2 rounded w-full">
                        <input type="text" name="espece" placeholder="Espèce (ex: Lion)" class="border p-2 rounded w-full">
                        <input type="text" name="alimentation" placeholder="Alimentation (ex: Carnivore)"
                            class="border p-2 rounded w-full">
                        <input type="text" name="pays" placeholder="Pays d'origine" class="border p-2 rounded w-full">
                        <select name="id_habitat" class="border p-2 rounded w-full">
                            <option value="">Choisir un habitat...</option>
                            <?php
                            if (isset($habitats_list)) {
                                foreach ($habitats_list as $h):
                                    ?>
                                    <option value="<?= $h->get_id() ?>">
                                        <?= $h->get_nom() ?>
                                    </option>

                                <?php endforeach;
                            } ?>
                        </select>
                        <div class="md:col-span-2">
                            <textarea name="description" placeholder="Description courte..."
                                class="border p-2 rounded w-full"></textarea>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm text-gray-500 mb-1">Image de l'animal</label>
                            <input name="image" type="url" placeholder="https://..." class="border p-2 rounded w-full">
                        </div>
                        <button name="creer_animal"
                            class="bg-maroc-green text-white py-2 px-6 rounded font-bold hover:bg-green-800 transition">Enregistrer</button>
                    </form>
                </div>

                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-gray-600 uppercase text-xs">
                            <th class="p-4">Image</th>
                            <th class="p-4">Nom</th>
                            <th class="p-4">Espèce</th>
                            <th class="p-4">Alimentation</th>
                            <th class="p-4">Pays</th>
                            <th class="p-4">Habitat</th>
                            <th class="p-4">Description</th>
                            <th class="p-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($animaux_list)) {
                            foreach ($animaux_list as $a): ?>
                                <tr class="border-b hover:bg-gray-50 align-middle">
                                    <td class="p-4">
                                        <?php if (!empty($a->get_image())): ?>
                                            <img src="<?= $a->get_image() ?>" alt="<?= $a->get_nom() ?>"
                                                class="w-12 h-12 rounded-full object-cover border-2 border-white shadow">
                                        <?php else: ?>
                                            <div
                                                class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center text-gray-400">
                                                <i class="fa-solid fa-camera"></i>
                                            </div>
                                        <?php endif; ?>
                                    </td>

                                    <td class="p-4 font-bold text-gray-800"><?= $a->get_nom() ?></td>
                                    <td class="p-4 text-gray-600"><?= $a->get_espece() ?></td>

                                    <td class="p-4">
                                        <span
                                            class="bg-orange-100 text-orange-800 text-xs font-bold px-2 py-1 rounded-full border border-orange-200">
                                            <?= $a->get_alimentation() ?>
                                        </span>
                                    </td>

                                    <td class="p-4">
                                        <span class="text-sm"><i
                                                class="fa-solid fa-location-dot text-red-500 mr-1"></i><?= $a->get_paysorigine() ?></span>
                                    </td>

                                    <td class="p-4">
                                        <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">
                                            Habitat #<?= $a->get_id_habitat() ?>
                                        </span>
                                    </td>

                                    <td class="p-4 text-sm text-gray-500 italic">
                                        <?= substr($a->get_descriptioncourte(), 0, 30) ?>...
                                    </td>

                                    <td class="p-4 text-right space-x-2">
                                        <button
                                            class="text-blue-500 hover:text-blue-700 transition bg-blue-50 p-2 rounded-full hover:bg-blue-100">
                                            <i class="fa-solid fa-pen"></i>
                                        </button>
                                        <button
                                            class="text-red-500 hover:text-red-700 transition bg-red-50 p-2 rounded-full hover:bg-red-100">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach;
                        } else {
                            echo "<tr><td colspan='8' class='p-4 text-center text-gray-500'>Aucun animal trouvé.</td></tr>";
                        } ?>
                    </tbody>
                </table>
            </div>

        <?php elseif ($section == 'habitats'): ?>
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="mb-8 p-6 bg-gray-50 rounded-lg border border-gray-200">
                    <h3 class="font-bold text-lg mb-4 text-maroc-green"><i class="fa-solid fa-plus-circle mr-2"></i>Ajouter
                        un nouvel habitat</h3>
                    <form action="?section=habitats" method="POST" enctype="multipart/form-data"
                        class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <input type="text" placeholder="Nom (ex : Savane)" class="border p-2 rounded w-full" name="nom">
                        <input type="text" placeholder="Type de Climat (ex : humide)" class="border p-2 rounded w-full"
                            name="typeclimat">
                        <input type="text" placeholder="Zone de l'habitat dans le zoo" class="border p-2 rounded w-full"
                            name="zonezoo">
                        <div class="md:col-span-2">
                            <textarea placeholder="Description courte..." class="border p-2 rounded w-full"
                                name="description"></textarea>
                        </div>
                        <button class="bg-maroc-green text-white py-2 px-6 rounded font-bold hover:bg-green-800 transition"
                            name="creer_habitat">Enregistrer</button>
                    </form>
                </div>

                <table class="w-full text-left border-collapse mt-8">
                    <thead>
                        <tr class="bg-gray-100 text-gray-600 uppercase text-xs">
                            <th class="p-4">Nom</th>
                            <th class="p-4">Type Climat</th>
                            <th class="p-4">Description</th>
                            <th class="p-4">Zone</th>
                            <th class="p-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($habitats_list)) {
                            foreach ($habitats_list as $h): ?>
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="p-4 font-bold"><?= $h->get_nom() ?></td>
                                    <td class="p-4 text-gray-600">
                                        <?= $h->get_typeclimat() ?>
                                    </td>
                                    <td class="p-4 text-sm text-gray-600 max-w-xs" title="<?= $h->get_description() ?>">
                                        <?php
                                        if (strlen($h->get_description()) > 50) {
                                            echo substr($h->get_description(), 0, 50) . '...';
                                        } else {
                                            echo $h->get_description();
                                        }
                                        ?>
                                    </td>

                                    <td class="p-4">
                                        <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">
                                            <?= $h->get_zonezoo() ?>
                                        </span>
                                    </td>
                                    <td class="p-4 text-right space-x-2">
                                        <button class="text-blue-500 hover:text-blue-700"><i class="fa-solid fa-pen"></i></button>
                                        <button class="text-red-500 hover:text-red-700"><i class="fa-solid fa-trash"></i></button>
                                    </td>
                                </tr>
                            <?php endforeach;
                        } ?>
                    </tbody>
                </table>
            </div>

        <?php elseif ($section == 'utilisateurs'): ?>
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="mb-4 flex justify-between items-center">
                    <h3 class="font-bold text-lg">Gestion des comptes</h3>
                </div>
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-gray-600 uppercase text-xs">
                            <th class="p-4">Nom</th>
                            <th class="p-4">Email</th>
                            <th class="p-4">Rôle</th>
                            <th class="p-4">Statut</th>
                            <th class="p-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users_list as $u): ?>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-4 font-bold"><?= $u->get_nom() ?></td>
                                <td class="p-4 text-gray-500"><?= $u->get_email() ?></td>
                                <td class="p-4">
                                    <?php
                                    $style_role = "bg-gray-100 text-gray-600";
                                    if ($u->get_statut() === 'admin') {
                                        $style_role = "bg-red-100 text-red-700 border border-red-200";
                                    } elseif ($u->get_statut() === 'guide') {
                                        $style_role = "bg-purple-100 text-purple-700";
                                    }
                                    ?>

                                    <span
                                        class="uppercase text-xs font-bold tracking-wide px-2 py-1 rounded <?= $style_role ?>">
                                        <?= $u->get_role() ?>
                                    </span>
                                </td>
                                <td class="p-4">
                                    <?php if ($u->get_statut() == 1): ?>
                                        <span
                                            class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">Actif</span>
                                    <?php else: ?>
                                        <span
                                            class="bg-red-500 text-white px-3 py-1 rounded-full text-xs font-bold animate-pulse">Inactif</span>
                                    <?php endif; ?>
                                </td>

                                <td class="p-4 text-right space-x-2">
                                    <?php if ($u->get_role() != 'admin'): ?>

                                        <?php if ($u->get_statut() == 0): ?>
                                            <a href="?section=utilisateurs&action=valider&id=<?= $u->get_id() ?>"
                                                class="bg-green-500 text-white px-3 py-1 rounded text-xs hover:bg-green-600 shadow inline-block">
                                                <i class="fa-solid fa-check"></i> Activer
                                            </a>
                                        <?php endif; ?>

                                        <a href="?section=utilisateurs&action=bannir&id=<?= $u->get_id() ?>"
                                            class="text-red-500 hover:text-red-700 border border-red-200 px-2 py-1 rounded hover:bg-red-50 inline-block"
                                            title="Bloquer">
                                            <i class="fa-solid fa-ban"></i>
                                        </a>

                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </main>
    <!-- Notifications d'erreur ou de succes -->
    <div class="notification success hidden fixed top-6 left-1/2 transform -translate-x-1/2 z-[999] bg-green-500 text-white px-10 py-4 rounded-full shadow-2xl border-4 border-white/30 text-lg font-bold text-center min-w-[350px] shadow-green-500/50"
        id="success_notification"></div>
    <div class="notification error hidden fixed top-6 left-1/2 transform -translate-x-1/2 z-[999] bg-red-500 text-white px-10 py-4 rounded-full shadow-2xl border-4 border-white/30 text-lg font-bold text-center min-w-[350px] shadow-green-500/50"
        id="error_notification"></div>
</body>

</html>