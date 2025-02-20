<?php
// include '../database/db.php';
// include '../database/partner_request.php';
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Partenaire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link href="custom.css" rel="stylesheet"> -->
    <link href="core.css" rel="stylesheet">
</head>

<body>
    <!-- Form controls -->
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header bg-gradient">
                <h5 class="card-header">Ajouter un Partenaire</h5>
            </div>
            <div class="card-body">
                <form method="post" action="">
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nom" name="Nom" placeholder="Nom du partenaire"
                            required />
                        <div class="invalid-feedback">Veuillez fournir un nom valide.</div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email<span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email" name="Email" placeholder="email@exemple.com"
                            required />
                        <div class="invalid-feedback">Veuillez fournir un email valide.</div>
                    </div>
                    <div class="mb-3">
                        <label for="telephone" class="form-label">Téléphone<span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="telephone" name="Telephone"
                            placeholder="Entrer le numéro de telephone" required />
                        <div class="invalid-feedback">Veuillez fournir un numéro de téléphone valide.</div>
                    </div>

                    <div class="mb-3">
                        <label for="adresse" class="form-label">Adresse</label>
                        <textarea class="form-control" id="adresse" name="Adresse" placeholder="Adresse (facultative)"
                            rows="3"></textarea>
                    </div>

                    <div class="text-center card-body">
                        <button type="submit" name="add_partner" class="btn btw-gradient">Ajouter le
                            Partenaire</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>