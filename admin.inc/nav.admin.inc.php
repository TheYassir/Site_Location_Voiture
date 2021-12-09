<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>ADmin - Gestion</title>
        <link rel="icon" type="image/x-icon" href="<?php URL ?>assets/favicon.ico" />
        <link href="<?php URL ?>css/styles.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.1/font/bootstrap-icons.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    </head>
    <body>
            <nav class="navbar navbar-dark bg-dark shadow-5-strong fixed-top">
                <div class="container-fluid">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample01" aria-controls="navbarsExample01" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarsExample01">
                        <ul class="navbar-nav me-auto mb-2">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="<?php URL ?>../-index.php">Accueil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php URL ?>../profil.php">Mon Compte</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-bs-toggle="dropdown" aria-expanded="false">ADMIN</a>
                            <ul class="dropdown-menu" aria-labelledby="dropdown01">
                            <li><a class="dropdown-item" href="gestion_commandes.php">Gestion Commandes</a></li>
                            <li><a class="dropdown-item" href="gestion_membres.php">Gestion Membres</a></li>
                            <li><a class="dropdown-item" href="gestion_vehicule.php">Gestion Véhicule</a></li>
                            <li><a class="dropdown-item" href="gestion_agences.php">Gestion Agences</a></li>
                            </ul>
                        </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <hr>