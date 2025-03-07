<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Flipside</title>
    <meta name="viewport" content="width=460, user-scalable=no" />
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,500' rel='stylesheet' type='text/css'>
    <link href="remove_concept.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <div class="btn">
        <div class="btn-back">
            <p>Êtes-vous sûr de vouloir faire ça ?</p>
            <button class="yes">Oui</button>
            <button class="no">Non</button>
        </div>
        <div class="btn-front">Supprimer</div>
    </div>
    <script src="remove_concept.js"></script>
    <style type="text/css" media="screen">
        .project-title {
            position: absolute;
            left: 25px;
            bottom: 8px;

            font-size: 16px;
            color: #444;
        }

        .credits {
            position: absolute;
            right: 20px;
            bottom: 25px;
            font-size: 15px;
            z-index: 20;
            color: #444;
            vertical-align: middle;
        }

        .credits *+* {
            margin-left: 15px;
        }

        .credits a {
            padding: 8px 10px;
            color: #444;
            border: 2px solid #999;
            text-decoration: none;
        }

        .credits a:hover {
            border-color: #555;
            color: #222;
        }

        @media screen and (max-width: 1040px) {
            .project-title {
                display: none;
            }

            .credits {
                width: 100%;
                left: 0;
                right: auto;
                bottom: 0;
                padding: 30px 0;
                background: #ddd;
                text-align: center;
            }

            .credits a {
                display: inline-block;
                margin-top: 7px;
                margin-bottom: 7px;
            }
        }
    </style>
</body>

</html>