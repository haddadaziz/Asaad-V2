<?php
session_start();
require_once 'config.php';
require_once 'classes/animal.php';
require_once 'classes/habitat.php';

$database = new Database();
$conn = $database->getConnection();

$choix_habitat = "";
if (isset($_GET['habitat'])) {
    $choix_habitat = $_GET['habitat'];
}

$choix_pays = "";
if (isset($_GET['pays'])) {
    $choix_pays = $_GET['pays'];
}

$animaux = Animal::filtrer_animaux($conn, $choix_habitat, $choix_pays);

$habitats_list = Habitat::find_all_habitats($conn);
?>

<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nos Animaux - Zoo ASSAD</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="script.js?v=<?= time() ?>" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;800&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
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
</head>

<body class="font-body bg-sand-light text-gray-800 flex flex-col min-h-screen">

    <nav class="bg-maroc-red text-white fixed w-full z-50 shadow-lg" id="navbar">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="index.php" class="flex items-center gap-3 group">
                <i class="fa-solid fa-paw text-yellow-400 text-2xl group-hover:rotate-12 transition"></i>
                <span class="font-headings font-bold text-2xl tracking-wider">ZOO ASSAD</span>
            </a>
            <div class="hidden md:flex items-center space-x-8 font-semibold text-sm uppercase">
                <a href="index.php" class="hover:text-yellow-300 transition">Accueil</a>
                <a href="animaux.php" class="text-yellow-300 font-bold border-b-2 border-yellow-300">Nos Animaux</a>
                <a href="index.php#visites" class="hover:text-yellow-300 transition">Visites</a>
            </div>
            <div class="hidden md:flex items-center space-x-4">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="visiteur.php" class="bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-full font-bold text-sm border border-white/50">Mon Espace</a>
                <?php else: ?>
                    <a href="login.php" class="bg-maroc-green hover:bg-green-800 text-white px-6 py-2 rounded-full font-bold shadow-md transition border border-green-700">Connexion</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <header class="relative h-[40vh] flex items-center justify-center overflow-hidden bg-gray-900">
        <img src="https://images.unsplash.com/photo-1517524942954-2a9f359c3821?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80" 
             alt="Jungle" class="absolute inset-0 w-full h-full object-cover opacity-60">
        <div class="relative z-10 text-center text-white px-6 mt-16">
            <h1 class="font-headings text-4xl md:text-6xl font-extrabold mb-4">Notre Grande Famille</h1>
            <p class="text-lg md:text-xl text-gray-200 max-w-2xl mx-auto">
                Parcourez notre collection unique d'espèces préservées avec soin.
            </p>
        </div>
    </header>

    <section class="py-16 px-6 container mx-auto">
        
        <div class="bg-white p-6 rounded-xl shadow-md border border-gray-100 mb-12 -mt-24 relative z-20">
            <form action="" method="GET" class="flex flex-col md:flex-row gap-4 items-end">
                
                <div class="w-full md:w-1/3">
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Habitat</label>
                    <div class="relative">
                        <select name="habitat" class="w-full appearance-none bg-gray-50 border border-gray-300 text-gray-700 py-3 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-maroc-green cursor-pointer">
                            <option value="">Tous les habitats</option>
                            <?php foreach($habitats_list as $h): ?>
                                <option value="<?= $h->get_id() ?>" 
                                    <?php if($choix_habitat == $h->get_id()) echo 'selected'; ?> >
                                    <?= $h->get_nom() ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500"><i class="fa-solid fa-chevron-down text-xs"></i></div>
                    </div>
                </div>

                <div class="w-full md:w-1/3">
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Pays d'origine</label>
                    <div class="relative">
                        <select name="pays" class="w-full appearance-none bg-gray-50 border border-gray-300 text-gray-700 py-3 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-maroc-green cursor-pointer">
                            <option value="">Tous les pays</option>
                            <option value="Maroc" <?php if($choix_pays == 'Maroc') echo 'selected'; ?>>Maroc 🇲🇦</option>
                            <option value="Kenya" <?php if($choix_pays == 'Kenya') echo 'selected'; ?>>Kenya 🇰🇪</option>
                            <option value="Tanzanie" <?php if($choix_pays == 'Tanzanie') echo 'selected'; ?>>Tanzanie 🇹🇿</option>
                            <option value="Afrique du Sud" <?php if($choix_pays == 'Afrique du Sud') echo 'selected'; ?>>Afrique du Sud 🇿🇦</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500"><i class="fa-solid fa-chevron-down text-xs"></i></div>
                    </div>
                </div>

                <div class="w-full md:w-1/3 flex gap-2">
                    <button type="submit" class="flex-grow bg-maroc-green hover:bg-green-800 text-white font-bold py-3 px-4 rounded-lg transition shadow flex items-center justify-center gap-2">
                        <i class="fa-solid fa-filter"></i> Filtrer
                    </button>
                    
                    <?php if(!empty($choix_habitat) || !empty($choix_pays)): ?>
                        <a href="animaux.php" class="bg-gray-200 hover:bg-gray-300 text-gray-600 font-bold py-3 px-4 rounded-lg transition flex items-center justify-center" title="Réinitialiser">
                            <i class="fa-solid fa-xmark"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <?php if(empty($animaux)): ?>
                <div class="col-span-4 text-center py-20">
                    <i class="fa-solid fa-hippo text-6xl text-gray-200 mb-4"></i>
                    <h3 class="text-xl font-bold text-gray-600">Aucun animal trouvé</h3>
                    <p class="text-gray-400">Essayez de modifier vos filtres.</p>
                </div>
            <?php else: ?>
                <?php foreach($animaux as $a): ?>
                    <div class="group bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 h-full flex flex-col hover:shadow-2xl hover:-translate-y-1 transition duration-300">
                        
                        <div class="h-64 overflow-hidden relative bg-gray-100">
                            <?php if(!empty($a->getImage())): ?>
                                <img src="<?= $a->getImage() ?>" alt="<?= $a->getNom() ?>" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                            <?php else: ?>
                                <div class="flex items-center justify-center h-full text-gray-400"><i class="fa-solid fa-paw text-4xl"></i></div>
                            <?php endif; ?>
                            
                            <div class="absolute top-3 right-3 bg-white/90 backdrop-blur text-xs font-bold px-2 py-1 rounded text-gray-800 shadow-sm">
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
                                
                                <button 
                                    onclick="openModal(this)"
                                    data-nom="<?= $a->getNom() ?>"
                                    data-desc="<?= $a->get_description_courte() ?>"
                                    data-image="<?= $a->getImage() ?>"
                                    data-pays="<?= $a->get_pays_origine() ?>"
                                    class="text-maroc-red hover:bg-red-50 p-2 rounded-full transition cursor-pointer"
                                    title="Voir détails">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

    </section>

    <footer class="bg-gray-900 text-white pt-16 pb-8 border-t-8 border-maroc-red mt-auto">
        <div class="container mx-auto px-6 text-center">
            <p class="text-gray-500 text-xs">&copy; 2025 Zoo Assad - Projet CAN 2025.</p>
        </div>
    </footer>

    <div id="animalModal" class="fixed inset-0 z-[9999] hidden flex items-center justify-center bg-black/70 backdrop-blur-sm transition-opacity duration-300">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 overflow-hidden transform transition-all scale-95" id="modalContent">
            <div class="relative h-48">
                <img id="modalImage" src="" alt="Animal" class="w-full h-full object-cover">
                <button onclick="closeModal()" class="absolute top-3 right-3 bg-white text-gray-800 hover:text-red-500 rounded-full w-8 h-8 flex items-center justify-center font-bold shadow-md transition">
                    <i class="fa-solid fa-xmark"></i>
                </button>
                <div class="absolute bottom-3 left-3 bg-maroc-red text-white text-xs font-bold px-3 py-1 rounded-full shadow-sm">
                    <i class="fa-solid fa-location-dot mr-1"></i> <span id="modalPays"></span>
                </div>
            </div>
            <div class="p-6">
                <h3 id="modalTitle" class="font-headings text-2xl font-bold text-gray-800 mb-2"></h3>
                <div class="w-12 h-1 bg-maroc-green rounded-full mb-4"></div>
                <p id="modalDesc" class="text-gray-600 text-sm leading-relaxed mb-6"></p>
                <button onclick="closeModal()" class="w-full bg-gray-900 text-white font-bold py-3 rounded-lg hover:bg-maroc-red transition">Fermer</button>
            </div>
        </div>
    </div>

</body>
</html>