document.addEventListener('DOMContentLoaded', function() {
    // Obtenir l'ID du client depuis l'URL
    const urlParams = new URLSearchParams(window.location.search);
    const clientId = urlParams.get('idclients');

    // Vérifier si clientId existe
    if (!clientId) {
        console.error('ID client manquant');
        return;
    }

    // Fonction pour supprimer un contact
    function deleteContact(contactId) {
        if (confirm('Êtes-vous sûr de vouloir supprimer ce contact ?')) {
            fetch('handle_contact.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'action=delete&id=' + contactId
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Recharger la page pour mettre à jour la liste
                    window.location.reload();
                } else {
                    alert('Erreur lors de la suppression : ' + data.message);
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Une erreur est survenue lors de la suppression');
            });
        }
    }

    // Gestion de la suppression des contacts
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function() {
            const contactId = this.dataset.id;
            deleteContact(contactId);
        });
    });

    // Gestion de la sélection multiple
    const selectAllCheckbox = document.getElementById('selectAll');
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            document.querySelectorAll('.contact-select').forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
    }

    // Gestion de l'importation CSV
    const importBtn = document.getElementById('import-csv-btn');
    const exportBtn = document.getElementById('export-csv-btn');
    
    if (importBtn) {
        importBtn.addEventListener('click', function() {
            // Créer un input file invisible
            const input = document.createElement('input');
            input.type = 'file';
            input.accept = '.csv';
            
            input.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (!file) return;
                
                // Créer le FormData
                const formData = new FormData();
                formData.append('csv_file', file);
                formData.append('idclients', new URLSearchParams(window.location.search).get('idclients'));
                
                // Envoyer le fichier
                fetch('import_csv.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        window.location.reload();
                    } else {
                        alert('Erreur : ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    alert('Une erreur est survenue lors de l\'importation');
                });
            });
            
            input.click();
        });
    }
    
    // Gestion de l'exportation CSV
    if (exportBtn) {
        exportBtn.addEventListener('click', function() {
            const clientId = new URLSearchParams(window.location.search).get('idclients');
            window.location.href = 'export_csv.php?idclients=' + clientId;
        });
    }
});
