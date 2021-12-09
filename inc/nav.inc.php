<?php
require_once 'inc/init.inc.php';
require_once 'inc/modal.inc.php'
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Yassir Loc</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    </head>
    <body>

<nav class="navbar navbar-dark shadow-5-strong colnav fixed-top">
    <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample01" aria-controls="navbarsExample01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarsExample01">
        <ul class="navbar-nav me-auto mb-2">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="<?= URL ?>-index.php">Accueil</a>
          </li>
          <?php if(!connect()): ?>
          <li class="nav-item">
          <button type="button" class="btn text-white" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            Inscription
            </button>
          </li>
          <li class="nav-item">
            <button type="button" class="btn text-white" data-bs-toggle="modal" data-bs-target="#staticBackdrop1">
            Connexion
            </button>
          </li>
          <?php else :?>
          <li class="nav-item pad">
            <a href="<?= URL ?>profil.php" class="nav-link">Mon Compte</a>
          </li>
          <?php endif ;?>
          <?php if(adminConnect()): ?>
          <li class="nav-item dropdown pad">
            <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-bs-toggle="dropdown" aria-expanded="false">ADMIN</a>
            <ul class="dropdown-menu" aria-labelledby="dropdown01">
              <li><a class="dropdown-item" href="#">Gestion Commandes</a></li>
              <li><a class="dropdown-item" href="admin/gestion_membres.php">Gestion Membres</a></li>
              <li><a class="dropdown-item" href="admin/gestion_vehicule.php">Gestion Vehicule</a></li>
              <li><a class="dropdown-item" href="admin/gestion_agences.php">Gestion Agences</a></li>
            </ul>
          </li>
          <?php endif ;?>
        </ul>
      </div>
      <?php if(connect()): ?>
        <span class="d-flex justify-content-center align-items-center">
            <span class="fst-italic text-white me-3">Bonjour <span class="text-success"><?= ucfirst($_SESSION['user']['pseudo']); ?></span> !</span>
            <a href="?action=deconnexion" class="btn btn-outline-danger text-white"><i class="bi bi-box-arrow-right text-white"></i> Déconnexion</a>
        </span>
      <?php endif; ?>
    </div>
  </nav>



