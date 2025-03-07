<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Modal Popup Formulaire</title>
    <style>
        /* Style de base pour la modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            width: 300px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            position: relative;
            animation: modalAppear 0.3s ease-out;
        }

        .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
            font-size: 20px;
        }

        @keyframes modalAppear {
            from {
                opacity: 0;
                transform: scale(0.7);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }
    </style>
</head>

<body>
    <a href="#" id="openModal">Ouvrir le Formulaire</a>

    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <h2>Formulaire</h2>
            <form>
                <label for="nom">Nom:</label>
                <input type="text" id="nom" name="nom" required><br><br>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required><br><br>

                <label for="message">Message:</label>
                <textarea id="message" name="message" required></textarea><br><br>

                <button type="submit">Envoyer</button>
            </form>
        </div>
    </div>

    <script>
        // Récupérer les éléments
        const modal = document.getElementById('myModal');
        const openModalLink = document.getElementById('openModal');
        const closeBtn = document.querySelector('.close-btn');

        // Empêcher le comportement par défaut du lien
        openModalLink.addEventListener('click', (e) => {
            e.preventDefault(); // Empêche le lien de naviguer
            modal.style.display = 'flex';
        });

        // Fermer la modal
        closeBtn.addEventListener('click', () => {
            modal.style.display = 'none';
        });

        // Fermer la modal si on clique en dehors
        window.addEventListener('click', (event) => {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });
    </script>
</body>

</html>