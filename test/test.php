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
    <link rel="stylesheet" href="custom_test.scss" type="text/x-scss">
    <script src="https://cdn.jsdelivr.net/npm/sass.js/dist/sass.sync.min.js"></script>
</head>

<body>

    <div class="button-container-2">
        <span class="mas">MASK2</span>
        <button type="button" name="Hover">MASK2</button>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Compile SCSS
        fetch('custom_test.scss')
            .then(response => response.text())
            .then(scss => {
                Sass.compile(scss, function (result) {
                    const style = document.createElement('style');
                    style.textContent = result.text;
                    document.head.appendChild(style);
                });
            });
    </script>
</body>

</html>