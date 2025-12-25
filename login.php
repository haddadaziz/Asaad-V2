<?php
session_start();
$message = "";
require_once 'config.php';
require_once 'classes/user.php';

$database = new Database();
$conn = $database->getConnection();

if (isset($_GET['redirect'])) {
    header("Location: login.php?status=must_be_connected");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];

    $user = User::verifier_login($conn, $email, $password);

    if ($user != null) {
        if ($user->get_statut() == 0) {
            header("Location: login.php?status=pending_registration");
        } else {
            $_SESSION['user_id'] = $user->get_id();
            $_SESSION['nom'] = $user->get_nom();
            $_SESSION['role'] = $user->get_role();

            if ($user->get_role() === 'admin') {
                header("Location: admin_dashboard.php?status=success_login");
            } elseif ($user->get_role() === 'guide') {
                header("Location: guide_dashboard.php?status=success_login");
            } else {
                header("Location: visiteur.php?status=success_login");
            }
            exit();
        }
    } else {
        header("Location: login.php?status=incorrect_login_infos");
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Connexion - Zoo Assad</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="script.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = { theme: { extend: { colors: { 'maroc-red': '#C1272D', 'maroc-green': '#006233' } } } }
    </script>
</head>

<body class="bg-gray-50 font-sans min-h-screen flex items-center justify-center p-4">

    <div class="max-w-md w-full bg-white rounded-xl shadow-2xl overflow-hidden">
        <div class="bg-maroc-red py-6 text-center">
            <h1 class="text-2xl font-bold text-white font-['Montserrat']">Espace Membre</h1>
            <p class="text-red-100 text-sm">Connectez-vous au Zoo Assad</p>
        </div>

        <div class="p-8">
            <?= $message ?>

            <form method="POST" action="">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                    <input type="email" name="email" required
                        class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-maroc-green">
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Mot de passe</label>
                    <input type="password" name="password" required
                        class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-maroc-green">
                    <a href="#" class="text-xs text-gray-500 hover:text-maroc-red float-right mt-1">Mot de passe oublié
                        ?</a>
                </div>

                <button type="submit"
                    class="w-full bg-maroc-green text-white font-bold py-3 rounded hover:bg-green-800 transition duration-300">
                    Se connecter
                </button>
            </form>

            <p class="mt-4 text-center text-sm text-gray-600">
                Pas encore de compte ? <a href="register.php"
                    class="text-maroc-red font-bold hover:underline">S'inscrire</a>
            </p>
            <p class="mt-2 text-center text-sm">
                <a href="index.php" class="text-gray-400 hover:text-gray-600">Retour à l'accueil</a>
            </p>
        </div>
    </div>
    <!-- Notifications d'erreur ou de succes -->
    <div class="notification success hidden fixed top-6 left-1/2 transform -translate-x-1/2 z-[999] bg-green-500 text-white px-10 py-4 rounded-full shadow-2xl border-4 border-white/30 text-lg font-bold text-center min-w-[350px] shadow-green-500/50"
        id="success_notification"></div>
    <div class="notification error hidden fixed top-6 left-1/2 transform -translate-x-1/2 z-[999] bg-red-500 text-white px-10 py-4 rounded-full shadow-2xl border-4 border-white/30 text-lg font-bold text-center min-w-[350px] shadow-green-500/50"
        id="error_notification"></div>
</body>

</html>