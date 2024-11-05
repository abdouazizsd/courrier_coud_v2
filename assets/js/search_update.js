
window.onbeforeunload = function() {
    document.forms['myForm'].reset();
};

document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('input[name="search"]');
    searchInput.addEventListener('input', function() {
        const url = new URL(window.location.href);
        const searchValue = searchInput.value.trim();

        if (searchValue === '') {
            // Supprime le paramètre 'search' de l'URL
            url.searchParams.delete('search');
        } else {
            // Met à jour le paramètre 'search' dans l'URL
            url.searchParams.set('search', searchValue);
        }

        // Met à jour l'URL sans recharger la page
        window.history.replaceState({}, '', url);
    });
});

document.getElementById('myForm1').addEventListener('submit', function(event) {
    var dateInput = document.getElementById('date').value;
    var selectedDate = new Date(dateInput);
    var today = new Date();
    
    // On vérifie que la date sélectionnée n'est pas dans le futur
    if (selectedDate > today) {
        Swal.fire({
            icon: 'error',
            title: 'Erreur de date',
            text: 'La date ne peut pas être dans le futur.',
            confirmButtonText: 'OK'
        });
        event.preventDefault();  // Empêche la soumission du formulaire
    }
});

document.getElementById('myForm2').addEventListener('submit', function(event) {
    var dateInput = document.getElementById('date_s').value;
    var selectedDate = new Date(dateInput);
    var today = new Date();
    
    // On vérifie que la date sélectionnée n'est pas dans le futur
    if (selectedDate > today) {
        Swal.fire({
            icon: 'error',
            title: 'Erreur de date',
            text: 'La date ne peut pas être dans le futur.',
            confirmButtonText: 'OK'
        });
        event.preventDefault();  // Empêche la soumission du formulaire
    }
});

document.getElementById('myForm').addEventListener('submit', function(event) {
    var dateInput = document.getElementById('date').value;
    var selectedDate = new Date(dateInput);
    var today = new Date();
    
    // On vérifie que la date sélectionnée n'est pas dans le futur
    if (selectedDate > today) {
        Swal.fire({
            icon: 'error',
            title: 'Erreur de date',
            text: 'La date ne peut pas être dans le futur.',
            confirmButtonText: 'OK'
        });
        event.preventDefault();  // Empêche la soumission du formulaire
    }
});

document.querySelectorAll('.delete-btn').forEach(button => {
    button.addEventListener('click', function(event) {
        event.preventDefault(); // Empêche le lien de fonctionner immédiatement

        const id = this.getAttribute('data-id'); // Récupère l'ID du courrier

        // Affiche la boîte de dialogue SweetAlert
        Swal.fire({
            title: 'Êtes-vous sûr de vouloir supprimer ce courrier?',
            text: "Cette action est irréversible!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Oui, supprimer!',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirige vers l'URL de suppression si confirmé
                window.location.href = `../../traitement/fonction.php?ids=${id}`;
            }
        });
    });
});