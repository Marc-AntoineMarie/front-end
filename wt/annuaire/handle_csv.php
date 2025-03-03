<?php
require_once '../database/db.php';
require_once '../database/Annuaire_request.php';
require_once '../utils/functions.php';

session_start();
if (!isset($_SESSION['role'])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Non autorisé']);
    exit;
}

$annuaireManager = new AnnuaireManager($pdo);

// Fonction pour nettoyer les données CSV
function cleanData($str) {
    return trim(str_replace(["\r", "\n"], '', $str));
}

// Gestion de l'import CSV
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'import_csv') {
    try {
        if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("Erreur lors de l'upload du fichier");
        }

        // Vérifier le type MIME
        $mimeType = mime_content_type($_FILES['file']['tmp_name']);
        if (!in_array($mimeType, ['text/csv', 'text/plain', 'application/vnd.ms-excel'])) {
            throw new Exception("Format de fichier non valide. Veuillez utiliser un fichier CSV.");
        }

        // Récupérer l'ID du client depuis l'URL
        $clientId = isset($_GET['idclients']) ? (int)$_GET['idclients'] : null;
        if (!$clientId) {
            throw new Exception("ID client manquant");
        }

        // Ouvrir le fichier
        $handle = fopen($_FILES['file']['tmp_name'], 'r');
        if (!$handle) {
            throw new Exception("Impossible d'ouvrir le fichier");
        }

        // Détecter et supprimer le BOM UTF-8 si présent
        $bom = fread($handle, 3);
        if ($bom !== "\xEF\xBB\xBF") {
            // Si ce n'est pas un BOM, on revient au début du fichier
            rewind($handle);
        }

        // Lire l'en-tête
        $header = fgetcsv($handle, 0, ',');
        if (!$header) {
            throw new Exception("En-tête CSV manquant");
        }

        // Nettoyer l'en-tête des caractères spéciaux et espaces
        $header = array_map(function($column) {
            return trim(str_replace(["\r", "\n", "\t"], '', $column));
        }, $header);

        // Vérifier les colonnes requises
        $requiredColumns = ['Prenom', 'Nom'];
        $headerMap = array_flip($header);
        foreach ($requiredColumns as $column) {
            if (!isset($headerMap[$column])) {
                throw new Exception("Colonne requise manquante : $column");
            }
        }

        // Compteurs pour le rapport
        $imported = 0;
        $errors = [];

        // Lire et importer les données
        while (($data = fgetcsv($handle, 0, ',')) !== FALSE) {
            try {
                if (count($data) !== count($header)) {
                    throw new Exception("Nombre de colonnes incorrect");
                }

                // Créer un tableau associatif des données
                $contact = array_combine($header, array_map('cleanData', $data));

                // Vérifier les champs requis
                if (empty($contact['Prenom']) || empty($contact['Nom'])) {
                    throw new Exception("Prénom et Nom sont requis");
                }

                // Ajouter le contact
                $result = $annuaireManager->addEntry(
                    $clientId,
                    $contact['Prenom'],
                    $contact['Nom'],
                    $contact['Email'] ?? '',
                    $contact['Societe'] ?? '',
                    $contact['Adresse'] ?? '',
                    $contact['Ville'] ?? '',
                    $contact['Telephone'] ?? '',
                    $contact['Commentaire'] ?? ''
                );

                if ($result) {
                    $imported++;
                }
            } catch (Exception $e) {
                $errors[] = "Ligne " . ($imported + count($errors) + 2) . ": " . $e->getMessage();
            }
        }

        fclose($handle);

        // Préparer le rapport
        $message = "$imported contacts importés avec succès.";
        if (!empty($errors)) {
            $message .= "\nErreurs:\n" . implode("\n", $errors);
        }

        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'message' => $message,
            'imported' => $imported,
            'errors' => $errors
        ]);

    } catch (Exception $e) {
        header('Content-Type: application/json');
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
}

// Gestion de l'export CSV
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'export_csv') {
    try {
        // Récupérer l'ID du client
        $clientId = isset($_GET['idclients']) ? (int)$_GET['idclients'] : null;
        if (!$clientId) {
            throw new Exception("ID client manquant");
        }

        // Récupérer les contacts
        $contacts = $annuaireManager->getAnnuaireByClient($clientId);

        // Préparer l'en-tête du fichier CSV
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="contacts.csv"');

        // Créer le fichier CSV
        $output = fopen('php://output', 'w');

        // Écrire l'en-tête UTF-8 BOM
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

        // Écrire l'en-tête
        fputcsv($output, ['Prenom', 'Nom', 'Email', 'Societe', 'Adresse', 'Ville', 'Telephone', 'Commentaire']);

        // Écrire les données
        foreach ($contacts as $contact) {
            fputcsv($output, [
                $contact['Prenom'],
                $contact['Nom'],
                $contact['Email'],
                $contact['Societe'],
                $contact['Adresse'],
                $contact['Ville'],
                $contact['Telephone'],
                $contact['Commentaire']
            ]);
        }

        fclose($output);
        exit;

    } catch (Exception $e) {
        header('Content-Type: application/json');
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
}
