<?php
session_start();
require_once 'config.php';
require_once 'classes/animal.php';

if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] === 'visiteur') {
        header("Location: visiteur.php");
    } elseif ($_SESSION['role'] === 'guide') {
        header("Location: guide_dashboard.php");
    } elseif ($_SESSION['role'] === 'admin') {
        header("Location: admin_dashboard.php");
    }
    exit();
}

$database = new Database();
$conn = $database->getConnection();
$animaux_vitrine = Animal::find_all_animaux($conn);
?>

<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zoo ASSAD - CAN 2025 Maroc</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="script.js?v=<?= time() ?>" defer></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;800&family=Open+Sans:wght@400;600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'maroc-red': '#C1272D',
                        'maroc-green': '#006233',
                        'sand-light': '#Fdfbf7',
                    },
                    fontFamily: {
                        'headings': ['Montserrat', 'sans-serif'],
                        'body': ['Open Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        .bg-pattern {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23006233' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
    </style>
</head>

<body class="font-body bg-sand-light text-gray-800 flex flex-col min-h-screen">

    <nav class="bg-maroc-red text-white fixed w-full z-50 shadow-lg transition-all duration-300" id="navbar">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="index.php" class="flex items-center gap-3 group">
                <i class="fa-solid fa-paw text-yellow-400 text-2xl group-hover:rotate-12 transition"></i>
                <div class="flex flex-col">
                    <span class="font-headings font-bold text-2xl tracking-wider">ZOO ASSAD</span>
                    <span class="text-xs text-yellow-300 font-semibold tracking-widest">CAN 2025 MAROC</span>
                </div>
            </a>

            <div class="hidden md:flex items-center space-x-8 font-semibold text-sm uppercase tracking-wide">
                <a href="#accueil" class="hover:text-yellow-300 transition">Accueil</a>
                <a href="#asaad" class="hover:text-yellow-300 transition">Asaad</a>
                <a href="#animaux" class="hover:text-yellow-300 transition">Nos Animaux</a>
                <a href="#visites" class="hover:text-yellow-300 transition">Visites</a>
            </div>

            <div class="hidden md:flex items-center space-x-4">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <span class="text-yellow-200 text-sm font-bold">Bonjour,
                        <?= htmlspecialchars($_SESSION['nom']) ?></span>
                    <?php if ($_SESSION['role'] == 'visiteur'): ?>
                        <a href="visiteur.php"
                            class="bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-full font-bold text-sm border border-white/50">Mon
                            Espace</a>
                    <?php elseif ($_SESSION['role'] == 'guide'): ?>
                        <a href="guide_dashboard.php"
                            class="bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-full font-bold text-sm border border-white/50">Espace
                            Guide</a>
                    <?php elseif ($_SESSION['role'] == 'admin'): ?>
                        <a href="admin_dashboard.php"
                            class="bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-full font-bold text-sm border border-white/50">Admin</a>
                    <?php endif; ?>
                    <a href="logout.php" class="text-white hover:text-yellow-200"><i class="fa-solid fa-power-off"></i></a>
                <?php else: ?>
                    <a href="login.php"
                        class="text-white hover:text-yellow-200 font-medium px-4 py-2 border border-transparent hover:border-white rounded transition">
                        <i class="fa-solid fa-user mr-2"></i>Connexion
                    </a>
                    <a href="register.php"
                        class="bg-maroc-green hover:bg-green-800 text-white px-6 py-2 rounded-full font-bold shadow-md transition transform hover:scale-105 border border-green-700">
                        Inscription
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <header id="accueil" class="relative h-screen flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1546182990-dffeafbe841d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80"
                alt="Lion Atlas" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-r from-maroc-red/80 to-black/50"></div>
        </div>

        <div class="container mx-auto px-6 relative z-10 grid md:grid-cols-2 gap-12 items-center pt-20">
            <div class="text-white space-y-6">
                <div
                    class="inline-flex items-center gap-2 bg-yellow-500 text-maroc-red font-bold px-4 py-1 rounded-full text-sm mb-2 shadow-lg animate-pulse">
                    <i class="fa-solid fa-futbol"></i> CAN 2025 MAROC
                </div>
                <h1 class="font-headings text-5xl md:text-7xl font-extrabold leading-tight drop-shadow-lg">
                    Bienvenue sur<br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 to-yellow-200">le
                        territoire d'Asaad</span>
                </h1>
                <p class="text-lg md:text-xl text-gray-100 max-w-lg leading-relaxed">
                    Explorez la richesse de la faune africaine et marocaine. Rejoignez l'aventure pour réserver vos
                    parcours exclusifs.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 pt-4">
                    <a href="#visites"
                        class="bg-maroc-green hover:bg-green-800 text-white text-center px-8 py-4 rounded-lg font-bold text-lg shadow-lg transition transform hover:-translate-y-1">
                        Réserver une visite
                    </a>
                    <a href="#animaux"
                        class="bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white text-white text-center px-8 py-4 rounded-lg font-bold text-lg transition">
                        Découvrir le parc
                    </a>
                </div>
            </div>
        </div>
    </header>

    <section id="asaad" class="py-20 bg-pattern">
        <div class="container mx-auto px-6">
            <div
                class="bg-white rounded-3xl shadow-xl overflow-hidden border-t-4 border-maroc-red flex flex-col md:flex-row">
                <div class="md:w-1/2 relative h-96 md:h-auto">
                    <img src="images/assad_mascotte.jpeg" alt="Lion Majestic" class="w-full h-full object-cover">
                    <div
                        class="absolute bottom-0 left-0 bg-maroc-green text-white px-6 py-2 rounded-tr-xl font-bold z-10">
                        #DimaMaghrib
                    </div>
                </div>
                <div class="md:w-1/2 p-10 md:p-16 flex flex-col justify-center space-y-6">
                    <h2 class="font-headings text-4xl font-bold text-maroc-red">Asaad : Lion de l'Atlas</h2>
                    <h3 class="text-xl font-semibold text-maroc-green">Symbole de la CAN 2025</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Le Lion de l'Atlas est plus qu'un animal, c'est l'emblème de notre nation. Asaad vous accueille
                        pour vous faire découvrir les secrets de son espèce, aujourd'hui éteinte à l'état sauvage mais
                        préservée ici.
                    </p>
                    <div class="grid grid-cols-2 gap-4 text-sm font-semibold text-gray-700">
                        <div class="flex items-center gap-2"><i class="fa-solid fa-weight-hanging text-maroc-red"></i>
                            200 kg</div>
                        <div class="flex items-center gap-2"><i class="fa-solid fa-ruler-horizontal text-maroc-red"></i>
                            2.80 m</div>
                    </div>
                    <button
                        class="w-max px-6 py-3 border-2 border-maroc-red text-maroc-red font-bold rounded-lg hover:bg-maroc-red hover:text-white transition mt-4">
                        Voir la fiche spéciale
                    </button>
                </div>
            </div>
        </div>
    </section>

    <section id="animaux" class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <span class="text-maroc-red font-bold tracking-widest uppercase text-sm">Faune Africaine</span>
                <h2 class="font-headings text-4xl font-extrabold text-gray-900 mt-2">Nos Pensionnaires</h2>
                <div class="w-24 h-1 bg-maroc-green mx-auto mt-4 rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">

                <?php
                // AFFICHER SEULEMENT 4 ANIMAUX (array_slice)
                if (isset($animaux_vitrine) && !empty($animaux_vitrine)):
                    foreach (array_slice($animaux_vitrine, 0, 4) as $a):
                        ?>
                        <div
                            class="group bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 h-full flex flex-col hover:shadow-2xl transition duration-300">
                            <div class="h-64 overflow-hidden relative bg-gray-100">
                                <?php if (!empty($a->getImage())): ?>
                                    <img src="<?= $a->getImage() ?>" alt="<?= $a->getNom() ?>"
                                        class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                <?php else: ?>
                                    <div class="flex items-center justify-center h-full text-gray-400">
                                        <i class="fa-solid fa-paw text-4xl"></i>
                                    </div>
                                <?php endif; ?>

                                <div
                                    class="absolute top-3 right-3 bg-white/90 backdrop-blur text-xs font-bold px-2 py-1 rounded text-gray-800 shadow-sm">
                                    <i class="fa-solid fa-location-dot text-maroc-red mr-1"></i> <?= $a->get_pays_origine() ?>
                                </div>
                            </div>

                            <div class="p-6 flex flex-col flex-grow">
                                <h3 class="font-headings font-bold text-xl text-gray-800 mb-1"><?= $a->getNom() ?></h3>
                                <p class="text-xs font-bold text-maroc-green uppercase tracking-wide mb-3">
                                    <?= $a->get_nom_habitat($conn) ?>
                                </p>

                                <div class="mt-auto border-t border-gray-100 pt-3 flex justify-between items-center">
                                    <span class="text-xs text-gray-500 italic"><?= $a->getEspece() ?></span>
                                    <button onclick="openModal(this)" data-nom="<?= $a->getNom() ?>"
                                        data-desc="<?= $a->get_description_courte() ?>" data-image="<?= $a->getImage() ?>"
                                        data-pays="<?= $a->get_pays_origine() ?>"
                                        class="text-maroc-red hover:bg-red-50 p-2 rounded-full transition cursor-pointer">

                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="col-span-4 text-center text-gray-500">Aucun animal n'est visible pour le moment.</p>
                <?php endif; ?>

            </div>

            <div class="text-center">
                <a href="animaux.php"
                    class="inline-flex items-center justify-center gap-3 bg-white border-2 border-gray-900 text-gray-900 hover:bg-gray-900 hover:text-white font-bold py-4 px-10 rounded-full transition duration-300 text-lg shadow-lg group">
                    <i class="fa-solid fa-paw group-hover:rotate-12 transition"></i> Explorer toute la collection
                </a>
                <p class="mt-4 text-gray-500 text-sm">Plus de <?= count($animaux_vitrine) ?> espèces à découvrir</p>
            </div>
        </div>
    </section>

    <section id="visites" class="py-20 bg-gray-50 relative">
        <div class="absolute top-0 left-0 w-full h-20 bg-gradient-to-b from-white to-gray-50"></div>
        <div class="container mx-auto px-6 relative z-10 text-center">
            <div class="mb-10">
                <span class="text-maroc-red font-bold tracking-widest uppercase text-sm">Agenda CAN 2025</span>
                <h2 class="font-headings text-4xl font-extrabold text-gray-900 mt-2">Réserver une visite</h2>
            </div>

            <div class="bg-white p-10 rounded-2xl shadow-xl max-w-2xl mx-auto border-t-4 border-maroc-green">
                <i class="fa-solid fa-ticket text-5xl text-maroc-green mb-4"></i>
                <h3 class="text-2xl font-bold text-gray-800 mb-2">Envie de visiter le zoo ?</h3>
                <p class="text-gray-600 mb-6">Connectez-vous à votre espace membre pour voir le planning des visites
                    guidées, réserver vos places et accéder à votre historique.</p>
                <div class="flex justify-center gap-4">
                    <a href="login.php"
                        class="bg-maroc-red text-white px-6 py-3 rounded-lg font-bold hover:bg-red-800 transition">Se
                        connecter</a>
                    <a href="register.php" class="text-maroc-green font-bold hover:underline px-6 py-3">Créer un
                        compte</a>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-gray-900 text-white pt-16 pb-8 border-t-8 border-maroc-red mt-auto">
        <div class="container mx-auto px-6">
            <div class="grid md:grid-cols-3 gap-12 mb-12">
                <div class="space-y-4">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-paw text-yellow-400 text-2xl"></i>
                        <span class="font-headings font-bold text-2xl">ZOO ASSAD</span>
                    </div>
                    <p class="text-gray-400 text-sm">Le zoo officiel de la Coupe d'Afrique des Nations 2025.</p>
                </div>
                <div>
                    <h4 class="font-bold text-lg mb-6 text-yellow-400">Liens Rapides</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><a href="login.php" class="hover:text-white">Connexion</a></li>
                        <li><a href="register.php" class="hover:text-white">Inscription</a></li>
                        <li><a href="#animaux" class="hover:text-white">Animaux</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-lg mb-6 text-yellow-400">Contact</h4>
                    <p class="text-gray-400 text-sm"><i class="fa-solid fa-envelope mr-2"></i> contact@zoo-assad.ma</p>
                    <p class="text-gray-400 text-sm"><i class="fa-solid fa-phone mr-2"></i> +212 5 22 00 00 00</p>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 text-center text-gray-500 text-xs">
                <p>&copy; 2025 Zoo Assad - Projet CAN 2025.</p>
            </div>
        </div>
    </footer>
    <!-- Popup details animal -->
    <div id="animalModal"
        class="fixed inset-0 z-[9999] hidden flex items-center justify-center bg-black/70 backdrop-blur-sm transition-opacity duration-300">

        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 overflow-hidden transform transition-all scale-95"
            id="modalContent">

            <div class="relative h-48">
                <img id="modalImage" src="" alt="Animal" class="w-full h-full object-cover">
                <button onclick="closeModal()"
                    class="absolute top-3 right-3 bg-white text-gray-800 hover:text-red-500 rounded-full w-8 h-8 flex items-center justify-center font-bold shadow-md transition">
                    <i class="fa-solid fa-xmark"></i>
                </button>
                <div
                    class="absolute bottom-3 left-3 bg-maroc-red text-white text-xs font-bold px-3 py-1 rounded-full shadow-sm">
                    <i class="fa-solid fa-location-dot mr-1"></i> <span id="modalPays"></span>
                </div>
            </div>

            <div class="p-6">
                <h3 id="modalTitle" class="font-headings text-2xl font-bold text-gray-800 mb-2"></h3>
                <div class="w-12 h-1 bg-maroc-green rounded-full mb-4"></div>
                <p id="modalDesc" class="text-gray-600 text-sm leading-relaxed mb-6">
                </p>

                <button onclick="closeModal()"
                    class="w-full bg-gray-900 text-white font-bold py-3 rounded-lg hover:bg-maroc-red transition">
                    Fermer
                </button>
            </div>
        </div>
    </div>
</body>

</html>