const success_notification = document.getElementById("success_notification");
const error_notification = document.getElementById("error_notification");

document.addEventListener("DOMContentLoaded", () => {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('status') === 'incorrect_login_infos') {
        display_red_notification("Email ou mot de passe incorrect!");
        window.history.replaceState({}, document.title, "login.php");
    }
    else if (urlParams.get('status') === 'success_compte_valider') {
        display_green_notification("Compte activé avec succès !");
        window.history.replaceState({}, document.title, "?section=utilisateurs");
    }
    else if (urlParams.get('status') === 'success_block_user') {
        display_green_notification("Utilisateur bloqué avec succès !");
        window.history.replaceState({}, document.title, "?section=utilisateurs");
    }
    else if (urlParams.get('status') === 'error_habitat_exists') {
        display_red_notification("Erreur ! Cet habitat existe déjà !");
        window.history.replaceState({}, document.title, "?section=habitats");
    }
    else if (urlParams.get('status') === 'success_ajout_habitat') {
        display_green_notification("Habitat ajouté avec succès !");
        window.history.replaceState({}, document.title, "?section=habitats");
    }
    else if (urlParams.get('status') === 'success_creation_visite') {
        display_green_notification("Visite crée avec succès !");
        window.history.replaceState({}, document.title, "?section=mes_visites");
    }
    else if (urlParams.get('status') === 'pending_registration') {
        display_green_notification("Votre compte est en attente de validation, il sera validé dans un délai de 24h max");
        window.history.replaceState({}, document.title, "login.php")
    }
    else if (urlParams.get('status') === 'success_login') {
        display_green_notification("Connecté avec succès !");
        window.history.replaceState({}, document.title, window.location.pathname);
    }
    else if (urlParams.get('status') === 'must_be_connected') {
        display_red_notification("Vous devez être connecté pour accéder à cette page.")
        window.history.replaceState({}, document.title, "login.php");
    }
    else if (urlParams.get('status') === 'erreur_creation_visite') {
        display_red_notification("Erreur, la visite n'a pas pu être créée !");
        window.history.replaceState({}, document.title, "?section=mes_visites");
    }
    else if (urlParams.get('status') === 'success_ajout_animal') {
        display_green_notification("Animal ajouté avec succès !");
        window.history.replaceState({}, document.title, "?section=animaux");
    }
    else if (urlParams.get('status') === 'success_registration') {
        display_green_notification("Compte crée avec succèes, connectez-vous !");
        window.history.replaceState({}, document.title, "login.php");
    }
    else if (urlParams.get('status') === 'error_full') {
        display_red_notification("Pas assez de place de disponibles");
        window.history.replaceState({}, document.title, "?#visites");
    }
    else if (urlParams.get('status') === 'success_reservation') {
        display_green_notification("Réservation confirmée");
        window.history.replaceState({}, document.title, "?#visites");
    }
})

function display_green_notification(msg) {
    error_notification.classList.add("hidden")
    success_notification.textContent = msg
    success_notification.classList.remove("hidden");
    setTimeout(() => {
        success_notification.classList.add("hidden")
    }, 3000)
}
function display_red_notification(msg) {
    success_notification.classList.add("hidden")
    error_notification.textContent = msg
    error_notification.classList.remove("hidden");
    setTimeout(() => {
        error_notification.classList.add("hidden")
    }, 3000)
}

function openModal(element) {
    let nom = element.getAttribute('data-nom');
    let desc = element.getAttribute('data-desc');
    let image = element.getAttribute('data-image');
    let pays = element.getAttribute('data-pays');

    document.getElementById('modalTitle').textContent = nom;
    document.getElementById('modalDesc').textContent = desc;
    document.getElementById('modalPays').textContent = pays;

    const imgElement = document.getElementById('modalImage');
    if (image) {
        imgElement.src = image;
    }

    const modal = document.getElementById('animalModal');
    modal.classList.remove('hidden');
    setTimeout(() => {
        document.getElementById('modalContent').classList.remove('scale-95');
        document.getElementById('modalContent').classList.add('scale-100');
    }, 10);
}

function closeModal() {
    const modal = document.getElementById('animalModal');
    const content = document.getElementById('modalContent');
    content.classList.remove('scale-100');
    content.classList.add('scale-95');
    setTimeout(() => {
        modal.classList.add('hidden');
    }, 200);
}

window.addEventListener('click', function (e) {
    const modal = document.getElementById('animalModal');
    if (e.target === modal) {
        closeModal();
    }
});
