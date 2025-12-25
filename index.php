<?php
require_once 'config.php';

$database = new Database();
$conn = $database->getConnection();
?>

<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zoo ASSAD - CAN 2025 Maroc</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="script.js" defer></script>
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
                <a href="#accueil"
                    class="hover:text-yellow-300 transition relative after:content-[''] after:absolute after:-bottom-1 after:left-0 after:w-0 after:h-0.5 after:bg-yellow-300 after:transition-all hover:after:w-full">Accueil</a>
                <a href="#asaad"
                    class="hover:text-yellow-300 transition relative after:content-[''] after:absolute after:-bottom-1 after:left-0 after:w-0 after:h-0.5 after:bg-yellow-300 after:transition-all hover:after:w-full">Asaad</a>
                <a href="#animaux"
                    class="hover:text-yellow-300 transition relative after:content-[''] after:absolute after:-bottom-1 after:left-0 after:w-0 after:h-0.5 after:bg-yellow-300 after:transition-all hover:after:w-full">Nos
                    Animaux</a>
                <a href="#visites"
                    class="hover:text-yellow-300 transition relative after:content-[''] after:absolute after:-bottom-1 after:left-0 after:w-0 after:h-0.5 after:bg-yellow-300 after:transition-all hover:after:w-full">Visites</a>
            </div>

            <div class="hidden md:flex items-center space-x-4">
                <a href="login.php"
                    class="text-white hover:text-yellow-200 font-medium px-4 py-2 border border-transparent hover:border-white rounded transition">
                    <i class="fa-solid fa-user mr-2"></i>Connexion
                </a>
                <a href="register.php"
                    class="bg-maroc-green hover:bg-green-800 text-white px-6 py-2 rounded-full font-bold shadow-md transition transform hover:scale-105 border border-green-700">
                    Inscription
                </a>
            </div>

            <button class="md:hidden text-2xl focus:outline-none">
                <i class="fa-solid fa-bars"></i>
            </button>
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

            <div class="max-w-4xl mx-auto bg-gray-50 p-6 rounded-2xl border border-gray-200 shadow-sm mb-12">
                <form action="" method="GET" class="flex flex-col md:flex-row gap-4 items-end">

                    <div class="w-full md:w-1/3">
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Filtrer par Habitat</label>
                        <div class="relative">
                            <select name="habitat"
                                class="w-full appearance-none bg-white border border-gray-300 text-gray-700 py-3 px-4 pr-8 rounded-lg focus:outline-none focus:ring-2 focus:ring-maroc-green focus:border-transparent cursor-pointer">
                                <option value="">Tous les habitats</option>
                                <option value="savane">Savane Africaine</option>
                                <option value="jungle">Jungle Tropicale</option>
                                <option value="montagne">Montagnes de l'Atlas</option>
                                <option value="desert">Désert du Sahara</option>
                                <option value="zone-humide">Zones Humides</option>
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <i class="fa-solid fa-chevron-down text-xs"></i>
                            </div>
                        </div>
                    </div>

                    <div class="w-full md:w-1/3">
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Filtrer par Pays</label>
                        <div class="relative">
                            <select name="pays"
                                class="w-full appearance-none bg-white border border-gray-300 text-gray-700 py-3 px-4 pr-8 rounded-lg focus:outline-none focus:ring-2 focus:ring-maroc-green focus:border-transparent cursor-pointer">
                                <option value="">Tous les pays</option>
                                <option value="maroc">🇲🇦 Maroc</option>
                                <option value="kenya">🇰🇪 Kenya</option>
                                <option value="tanzanie">🇹🇿 Tanzanie</option>
                                <option value="afrique-sud">🇿🇦 Afrique du Sud</option>
                                <option value="congo">🇨🇩 Congo</option>
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <i class="fa-solid fa-chevron-down text-xs"></i>
                            </div>
                        </div>
                    </div>

                    <div class="w-full md:w-1/3">
                        <button type="submit"
                            class="w-full bg-maroc-green hover:bg-green-800 text-white font-bold py-3 px-4 rounded-lg transition shadow-md flex items-center justify-center gap-2">
                            <i class="fa-solid fa-filter"></i> Appliquer les filtres
                        </button>
                    </div>
                </form>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">

                <div
                    class="group bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300 border border-gray-100 flex flex-col">
                    <div class="h-64 overflow-hidden relative">
                        <img src="https://images.unsplash.com/photo-1547721064-da6cfb341d50?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
                            alt="Lion" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        <div
                            class="absolute top-3 right-3 bg-white/90 backdrop-blur text-xs font-bold px-2 py-1 rounded text-gray-800 shadow-sm">
                            <i class="fa-solid fa-location-dot text-maroc-red mr-1"></i> Maroc
                        </div>
                    </div>
                    <div class="p-6 flex flex-col flex-grow">
                        <h3 class="font-headings font-bold text-xl text-gray-800 mb-1">Lion de l'Atlas</h3>
                        <p class="text-xs font-bold text-maroc-green uppercase tracking-wide mb-3">Montagnes</p>
                        <div class="mt-auto border-t border-gray-100 pt-3 flex justify-between items-center">
                            <span class="text-xs text-gray-500">Panthera leo leo</span>
                            <a href="#" class="text-maroc-red hover:bg-red-50 p-2 rounded-full transition"><i
                                    class="fa-solid fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <div
                    class="group bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300 border border-gray-100 flex flex-col">
                    <div class="h-64 overflow-hidden relative">
                        <img src="https://images.unsplash.com/photo-1557008075-7f2c5efa4cfd?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
                            alt="Girafe"
                            class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        <div
                            class="absolute top-3 right-3 bg-white/90 backdrop-blur text-xs font-bold px-2 py-1 rounded text-gray-800 shadow-sm">
                            <i class="fa-solid fa-location-dot text-maroc-red mr-1"></i> Kenya
                        </div>
                    </div>
                    <div class="p-6 flex flex-col flex-grow">
                        <h3 class="font-headings font-bold text-xl text-gray-800 mb-1">Girafe Réticulée</h3>
                        <p class="text-xs font-bold text-maroc-green uppercase tracking-wide mb-3">Savane</p>
                        <div class="mt-auto border-t border-gray-100 pt-3 flex justify-between items-center">
                            <span class="text-xs text-gray-500">Giraffa camelopardalis</span>
                            <a href="#" class="text-maroc-red hover:bg-red-50 p-2 rounded-full transition"><i
                                    class="fa-solid fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <div
                    class="group bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300 border border-gray-100 flex flex-col">
                    <div class="h-64 overflow-hidden relative">
                        <img src="https://images.unsplash.com/photo-1570042770669-709772a832c6?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
                            alt="Zèbre"
                            class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        <div
                            class="absolute top-3 right-3 bg-white/90 backdrop-blur text-xs font-bold px-2 py-1 rounded text-gray-800 shadow-sm">
                            <i class="fa-solid fa-location-dot text-maroc-red mr-1"></i> Tanzanie
                        </div>
                    </div>
                    <div class="p-6 flex flex-col flex-grow">
                        <h3 class="font-headings font-bold text-xl text-gray-800 mb-1">Zèbre des plaines</h3>
                        <p class="text-xs font-bold text-maroc-green uppercase tracking-wide mb-3">Savane</p>
                        <div class="mt-auto border-t border-gray-100 pt-3 flex justify-between items-center">
                            <span class="text-xs text-gray-500">Equus quagga</span>
                            <a href="#" class="text-maroc-red hover:bg-red-50 p-2 rounded-full transition"><i
                                    class="fa-solid fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <div
                    class="group bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300 border border-gray-100 flex flex-col">
                    <div class="h-64 overflow-hidden relative">
                        <img src="https://images.unsplash.com/photo-1535591273668-578e31182c4f?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
                            alt="Macaque"
                            class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        <div
                            class="absolute top-3 right-3 bg-white/90 backdrop-blur text-xs font-bold px-2 py-1 rounded text-gray-800 shadow-sm">
                            <i class="fa-solid fa-location-dot text-maroc-red mr-1"></i> Maroc
                        </div>
                    </div>
                    <div class="p-6 flex flex-col flex-grow">
                        <h3 class="font-headings font-bold text-xl text-gray-800 mb-1">Macaque de Barbarie</h3>
                        <p class="text-xs font-bold text-maroc-green uppercase tracking-wide mb-3">Forêt de Cèdres</p>
                        <div class="mt-auto border-t border-gray-100 pt-3 flex justify-between items-center">
                            <span class="text-xs text-gray-500">Macaca sylvanus</span>
                            <a href="#" class="text-maroc-red hover:bg-red-50 p-2 rounded-full transition"><i
                                    class="fa-solid fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <a href="animaux.php"
                    class="inline-flex items-center justify-center gap-3 bg-white border-2 border-gray-900 text-gray-900 hover:bg-gray-900 hover:text-white font-bold py-4 px-10 rounded-full transition duration-300 text-lg shadow-lg group">
                    <i class="fa-solid fa-paw group-hover:rotate-12 transition"></i>
                    Explorer toute la collection
                </a>
                <p class="mt-4 text-gray-500 text-sm">Plus de 50 espèces à découvrir</p>
            </div>

        </div>
    </section>

    <section id="visites" class="py-20 bg-gray-50 relative">
        <div class="absolute top-0 left-0 w-full h-20 bg-gradient-to-b from-white to-gray-50"></div>

        <div class="container mx-auto px-6 relative z-10">

            <div class="text-center mb-10">
                <span class="text-maroc-red font-bold tracking-widest uppercase text-sm">Agenda CAN 2025</span>
                <h2 class="font-headings text-4xl font-extrabold text-gray-900 mt-2">Trouvez votre parcours</h2>
            </div>

            <div
                class="max-w-4xl mx-auto bg-white p-2 rounded-full shadow-xl border border-gray-200 mb-16 transform -translate-y-4">
                <form action="" method="GET" class="flex flex-col md:flex-row items-center p-2 gap-2">
                    <div class="flex-grow w-full md:w-auto flex items-center px-4">
                        <i class="fa-solid fa-magnifying-glass text-gray-400 mr-3"></i>
                        <input type="text" placeholder="Rechercher une visite (ex: Safari, Lions...)"
                            class="w-full bg-transparent border-none focus:ring-0 text-gray-700 placeholder-gray-400"
                            name="search">
                    </div>
                    <div class="h-8 w-px bg-gray-300 hidden md:block"></div>
                    <div class="w-full md:w-auto px-4">
                        <select name="date"
                            class="w-full bg-transparent border-none focus:ring-0 text-gray-700 cursor-pointer">
                            <option value="">Toutes les dates</option>
                            <option value="today">Aujourd'hui</option>
                            <option value="demain">Demain</option>
                            <option value="weekend">Ce week-end</option>
                        </select>
                    </div>
                    <button type="submit"
                        class="w-full md:w-auto bg-maroc-red hover:bg-red-700 text-white font-bold py-3 px-8 rounded-full transition shadow-md flex items-center justify-center gap-2">
                        Rechercher
                    </button>
                </form>
            </div>

            <div class="grid md:grid-cols-3 gap-8">

                <div
                    class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden flex flex-col h-full hover:shadow-xl transition duration-300 group">
                    <div class="relative h-48 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1596716766417-76813296c00e?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                            alt="Safari"
                            class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                        <div
                            class="absolute top-4 right-4 bg-maroc-green text-white font-bold px-3 py-1 rounded-md text-sm shadow-sm">
                            150 MAD
                        </div>
                    </div>
                    <div class="p-6 flex flex-col flex-grow">
                        <div class="flex justify-between items-start mb-2">
                            <span class="text-maroc-red font-bold text-xs uppercase tracking-wide">Aventure</span>
                            <span class="text-gray-400 text-xs"><i class="fa-solid fa-calendar mr-1"></i> 15 Déc</span>
                        </div>
                        <h3 class="font-headings font-bold text-xl mb-2 text-gray-800">Sur les traces d'Asaad</h3>
                        <p class="text-gray-500 text-sm mb-4 flex-grow">Un parcours immersif au cœur de la zone Atlas
                            pour découvrir l'histoire de notre mascotte.</p>

                        <div class="border-t border-gray-100 pt-4 mt-auto">
                            <div class="flex items-center justify-between text-sm text-gray-600 mb-4">
                                <span class="flex items-center gap-2 bg-gray-100 px-2 py-1 rounded"><i
                                        class="fa-regular fa-clock"></i> 1h30</span>
                                <span class="flex items-center gap-2"><i
                                        class="fa-solid fa-user-group text-maroc-green"></i> 5 places</span>
                            </div>

                            <a href="login.php?redirect=reservation"
                                class="block w-full text-center bg-gray-100 text-gray-600 py-3 rounded-lg font-bold hover:bg-maroc-red hover:text-white transition shadow-sm group-hover:shadow-lg border border-gray-200">
                                <i class="fa-solid fa-lock mr-2 text-sm"></i> Connectez-vous pour réserver
                            </a>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden flex flex-col h-full hover:shadow-xl transition duration-300 group">
                    <div class="relative h-48 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1518709414768-a88981a4515d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                            alt="Oiseaux"
                            class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                        <div
                            class="absolute top-4 right-4 bg-maroc-green text-white font-bold px-3 py-1 rounded-md text-sm shadow-sm">
                            120 MAD
                        </div>
                    </div>
                    <div class="p-6 flex flex-col flex-grow">
                        <div class="flex justify-between items-start mb-2">
                            <span class="text-maroc-red font-bold text-xs uppercase tracking-wide">Découverte</span>
                            <span class="text-gray-400 text-xs"><i class="fa-solid fa-calendar mr-1"></i> 16 Déc</span>
                        </div>
                        <h3 class="font-headings font-bold text-xl mb-2 text-gray-800">Les Ailes de l'Afrique</h3>
                        <p class="text-gray-500 text-sm mb-4 flex-grow">Observation ornithologique guidée. Idéal pour
                            les photographes amateurs.</p>

                        <div class="border-t border-gray-100 pt-4 mt-auto">
                            <div class="flex items-center justify-between text-sm text-gray-600 mb-4">
                                <span class="flex items-center gap-2 bg-gray-100 px-2 py-1 rounded"><i
                                        class="fa-regular fa-clock"></i> 2h00</span>
                                <span class="flex items-center gap-2"><i
                                        class="fa-solid fa-user-group text-maroc-green"></i> 12 places</span>
                            </div>

                            <a href="login.php?redirect=reservation"
                                class="block w-full text-center bg-gray-100 text-gray-600 py-3 rounded-lg font-bold hover:bg-maroc-red hover:text-white transition shadow-sm group-hover:shadow-lg border border-gray-200">
                                <i class="fa-solid fa-lock mr-2 text-sm"></i> Connectez-vous pour réserver
                            </a>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden flex flex-col h-full hover:shadow-xl transition duration-300 group">
                    <div class="relative h-48 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1518531933037-91b2f5f229cc?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                            alt="Botanique"
                            class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                        <div
                            class="absolute top-4 right-4 bg-maroc-green text-white font-bold px-3 py-1 rounded-md text-sm shadow-sm">
                            100 MAD
                        </div>
                    </div>
                    <div class="p-6 flex flex-col flex-grow">
                        <div class="flex justify-between items-start mb-2">
                            <span class="text-maroc-red font-bold text-xs uppercase tracking-wide">Écologie</span>
                            <span class="text-gray-400 text-xs"><i class="fa-solid fa-calendar mr-1"></i> Tlj</span>
                        </div>
                        <h3 class="font-headings font-bold text-xl mb-2 text-gray-800">Botanique & Habitats</h3>
                        <p class="text-gray-500 text-sm mb-4 flex-grow">Comprendre l'importance de la flore pour la
                            survie des espèces animales.</p>

                        <div class="border-t border-gray-100 pt-4 mt-auto">
                            <div class="flex items-center justify-between text-sm text-gray-600 mb-4">
                                <span class="flex items-center gap-2 bg-gray-100 px-2 py-1 rounded"><i
                                        class="fa-regular fa-clock"></i> 1h00</span>
                                <span class="flex items-center gap-2"><i
                                        class="fa-solid fa-user-group text-maroc-green"></i> 20 places</span>
                            </div>

                            <a href="login.php?redirect=reservation"
                                class="block w-full text-center bg-gray-100 text-gray-600 py-3 rounded-lg font-bold hover:bg-maroc-red hover:text-white transition shadow-sm group-hover:shadow-lg border border-gray-200">
                                <i class="fa-solid fa-lock mr-2 text-sm"></i> Connectez-vous pour réserver
                            </a>
                        </div>
                    </div>
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
                    <p class="text-gray-400 text-sm">
                        Le zoo officiel de la Coupe d'Afrique des Nations 2025.
                    </p>
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
    <!-- Notifications d'erreur ou de succes -->
    <div class="notification success hidden fixed top-6 left-1/2 transform -translate-x-1/2 z-[999] bg-green-500 text-white px-10 py-4 rounded-full shadow-2xl border-4 border-white/30 text-lg font-bold text-center min-w-[350px] shadow-green-500/50"
        id="success_notification"></div>
    <div class="notification error hidden fixed top-6 left-1/2 transform -translate-x-1/2 z-[999] bg-red-500 text-white px-10 py-4 rounded-full shadow-2xl border-4 border-white/30 text-lg font-bold text-center min-w-[350px] shadow-green-500/50"
        id="error_notification"></div>
</body>

</html>