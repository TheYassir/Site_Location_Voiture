<?php
############################################# DECONNECTION #####################################################

if(isset($_GET['action']) && $_GET['action'] == 'deconnexion'){
  unset($_SESSION['user']);
}
// !connect() ||
if(isset($_GET['action']) && $_GET['action'] == 'deconnexion')
{
  header('location: -index.php');
}

############################################# DECONNECTION #####################################################


############################################# CONNECTION #####################################################
// echo '<pre>'; print_r($_SESSION); echo '</pre>';
if(isset($_POST['pseudo_email'], $_POST['password'])){
    $verifCredentials = $bdd->prepare("SELECT * FROM membre WHERE pseudo = :pseudo OR email = :email");
    $verifCredentials->bindValue(':pseudo', $_POST['pseudo_email'], PDO::PARAM_STR);
    $verifCredentials->bindValue(':email', $_POST['pseudo_email'], PDO::PARAM_STR);
    $verifCredentials->execute();

    if($verifCredentials->rowCount()){
      $user = $verifCredentials->fetch(PDO::FETCH_ASSOC);
        if(password_verify($_POST['password'], $user['password'])){
          foreach($user as $key => $value){
            if($key != 'password')
            $_SESSION['user'][$key] = $value;
          }
            // header('location: profil.php');
        } else {
          $error1 = "Identifiants ou mot de passe invalide.";
        }
    } else {
      $error1 = "Identifiants ou mot de passe invalide.";
    }
}
############################################# CONNECTION #####################################################


############################################# INSCRIPTION #####################################################
if(isset($_POST['sexe'], $_POST['pseudo'], $_POST['password'], $_POST['confirm_password'], $_POST['email'], $_POST['prenom'], $_POST['nom'])){
  $border = 'border border-danger';
  $color = 'text-danger';
  $verifPseudo = $bdd->prepare("SELECT * FROM membre WHERE pseudo = :pseudo");
  $verifPseudo->bindValue(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
  $verifPseudo->execute();

  if($verifPseudo->rowCount()){
      $errorPseudo = "Nom d'utilisateur déjà existant. Merci d'en saisir un nouveau.";

      $error = true;
  } elseif(empty($_POST['pseudo'])){
      $errorPseudo = "Merci de saisir un nom d'utilisateur.";

      $error = true;
  }

  $verifEmail = $bdd->prepare("SELECT * FROM membre WHERE email = :email");
  $verifEmail->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
  $verifEmail->execute();

  if($verifEmail->rowCount()){
      $errorEmail = 'Compte existant. Merci de vous identifier&nbsp;<button type="button" class=" btn-sm btn btn-outline-danger mx-auto" data-bs-toggle="modal" data-bs-target="#staticBackdrop1"> Cliquez ici !</button>';

      $error = true;
  } elseif(empty($_POST['email'])){
      $errorEmail = "Merci de saisir votre adresse Email.";

      $error = true;
  } elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
      $errorEmail = "Merci de saisir une adresse Email valide (ex: exemple@gmail.com).";

      $error = true;
  }

  if($_POST['password'] != $_POST['confirm_password']){
      $errorPassword = "Les mots de passe ne correspondent pas.";

      $error = true;
  }

  if(empty($_POST['gridCheck']))
  {
      $errorGridCheck = "Vous devez accepter les politiques de confidentialités.";

      $error = true;
  }

  if(!isset($error)){
    $_POST['password'] = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $inscription = $bdd->prepare("INSERT INTO membre (pseudo, password, nom, prenom, email, sexe, date_enregistrement	) VALUES (:pseudo, :password, :nom, :prenom, :email, :sexe, NOW())");
    $inscription->bindValue(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
    $inscription->bindValue(':password', $_POST['password'], PDO::PARAM_STR);
    $inscription->bindValue(':nom', $_POST['nom'], PDO::PARAM_STR);
    $inscription->bindValue(':prenom', $_POST['prenom'], PDO::PARAM_STR);
    $inscription->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
    $inscription->bindValue(':sexe', $_POST['sexe'], PDO::PARAM_STR);
    $inscription->execute();


    ################ CONNEXION DIRECT APRES INSCRIPTION ###################
    $connectdirect = $bdd->prepare("SELECT * FROM membre WHERE pseudo = :pseudo OR email = :email");
    $connectdirect->bindValue(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
    $connectdirect->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
    $connectdirect->execute();
    $user = $connectdirect->fetch(PDO::FETCH_ASSOC);
    foreach($user as $key => $value){
      if($key != 'password')
      $_SESSION['user'][$key] = $value;
    }
    ################ CONNEXION DIRECT APRES INSCRIPTION ###################

    // echo '<pre>'; print_r($user); echo '</pre>';
    // echo '<pre>'; print_r($_SESSION); echo '</pre>';
    // header('location: profil.php');
  }
}
############################################# INSCRIPTION #####################################################

?>



  <!-- ########################################## INSCRIPTION ################################################ -->

<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fs-3" id="staticBackdropLabel">Inscription</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <h1 class="text-center my-5">Créer votre compte</h1>
      <form method="post" class="container d-flex justify-content-center row g-3 mb-5">
        <div class="col-md-6">
          <label for="sexe" class="form-label">Civilité</label>
          <select class="form-select" name="sexe" id="sexe">
              <option value="femme" <?php if(isset($_POST['sexe']) && $_POST['sexe'] == "femme") echo "selected";?>>Madame</option>
              <option value="homme" <?php if(isset($_POST['sexe']) && $_POST['sexe'] == "homme") echo "selected";?>>Monsieur</option>
          </select>
        </div>
        <div class="col-md-6">

            <label for="pseudo" class="form-label">Nom d'utilisateur</label>

            <input type="text" class="form-control <?php if(isset($errorPseudo)) echo $border; ?>" id="pseudo" name="pseudo" value="<?php if(isset($_POST['pseudo'])) echo $_POST['pseudo']; ?>">

            <?php if(isset($errorPseudo)): ?>
                <small class="fst-italic text-danger"><?= $errorPseudo ?></small>
            <?php endif; ?>

        </div>
        <div class="col-md-6">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" class="form-control <?php if(isset($errorPassword)) echo $border; ?>" id="password" name="password">

            <?php if(isset($errorPassword)): ?>
                <small class="fst-italic text-danger"><?= $errorPassword ?></small>
            <?php endif; ?>
        </div>
        <div class="col-md-6">
            <label for="confirm_password" class="form-label">Confirmer&nbsp;votre&nbsp;mot&nbsp;de&nbsp;passe</label>
            <input type="password" class="form-control <?php if(isset($errorPassword)) echo $border; ?>" id="confirm_password" name="confirm_password">
        </div>
        <div class="col-md-6">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" class="form-control" id="nom" name="nom" placeholder="Saisir votre nom" value="<?php if(isset($_POST['nom'])) echo $_POST['nom']; ?>">
        </div>
        <div class="col-6">
            <label for="prenom" class="form-label">Prénom</label>
            <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Saisir votre prénom" value="<?php if(isset($_POST['prenom'])) echo $_POST['prenom']; ?>">
        </div>

        <div class="col-8">
            <label for="email" class="form-label">Email</label>
            <input type="text" class="form-control <?php if(isset($errorEmail)) echo $border; ?>" id="email" name="email" placeholder="Saisir votre adresse email" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>">

            <?php if(isset($errorEmail)): ?>
                <small class="fst-italic text-danger"><?= $errorEmail ?></small>
            <?php endif; ?>

        </div>
        <div class="col-12">
            <div class="form-check">
                <input class="form-check-input <?php if(isset($errorGridCheck)) echo $border; ?>" type="checkbox" id="gridCheck" name="gridCheck">
                <label class="form-check-label <?php if(isset($errorGridCheck)) echo $color; ?>" for="gridCheck">
                Accepter les <a href="" class="alert-link <?php if(isset($errorGridCheck)) echo $color; else echo 'text-dark' ?>">politiques de confidentialité</a>
                </label>
            </div>
        </div>
        <div class="col-3">
            <button type="submit" class="btn btn-dark" data-bs-target="#exampleModalToggle2">Continuer</button>
        </div>
        <div class="modal-footer">
            <p class="text-end mb-0">Vous avez déjà un compte ?<br>
                <button type="button" class=" btn-sm btn btn-outline-success mx-auto" data-bs-toggle="modal" data-bs-target="#staticBackdrop1"> Cliquez ici !</button>
            </p>
        </div>
      </form>
      </div>
    </div>
  </div>
</div>
<!-- ########################################## INSCRIPTION ################################################ -->




<!-- ########################################## CONNEXION ################################################ -->
<div class="modal fade" id="staticBackdrop1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Connexion</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" method="post" class=" container col-8 mx-auto">
        <?php if(isset($error1)): ?>
            <p class="alert-danger alert mx-auto p-3 text-center mt-3"><?= $error1; ?></p>
        <?php endif; ?>
          <div class="mb-3">
              <label for="pseudo_email" class="form-label">Nom d'utilisateur / Email</label>
              <input type="text" class="form-control" id="pseudo_email" name="pseudo_email" placeholder="Saisir votre Email ou votre nom d'utilisateur">
          </div>
          <div class="mb-3">
              <label for="password" class="form-label">Mot de passe</label>
              <input type="password" class="form-control" id="password" name="password" placeholder="Saisir votre mot de passe">
          </div>
          <div>
              <button <?php if(isset($error1)): ?> data-bs-toggle="modal" data-bs-target="#staticBackdrop2" <?php endif; ?> type="submit" class="btn btn-dark mb-4">Continuer</button>
          </div>
          <div class="modal-footer">
              <p class="text-end mb-0">Pas encore de compte ?<br>
                <button type="button" class=" btn-sm btn btn-outline-success mx-auto" data-bs-toggle="modal" data-bs-target="#staticBackdrop"> Cliquez ici !</button>
            </p>
            <p class="text-end m-0 p-0"><a href="" class="alert-link text-dark">Mot de passe oublié ?</a></p>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- ########################################## CONNEXION ################################################ -->


<!-- ########################################## FICHE VEHICULE ################################################ -->

<div class="modal fade" id="fichevec" tabindex="-1" aria-labelledby="fichevec" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
      
        <h5 class="modal-title" id="fichevec"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post" class="mx-auto">
        <?php if(isset($error3)): ?>
            <p class="alert-danger alert mx-auto p-3 text-center mt-3">Veuillez entrer les dates et heures voulu</p>
        <?php endif; ?>
        <div class="p-3 row">
            <p class="pb-1">Début de location</p>
            <input type="datetime-local" class="form-control" id="date_heure_depart" name="date_heure_depart">
        </div>
        <div class="p-3 row">
            <p class="pb-1">Fin de location</p>
            <input type="datetime-local" class="form-control" id="date_heure_fin" name="date_heure_fin">
        </div>
        <div class="modal-footer mx-auto row col-md-6">
            <button type="submit" class="mx-auto btn btn-success text-white mt-3">Valider&nbsp;un&nbsp;véhicule</button>
        </div>


        </form>      
      </div>
    </div>
  </div>
</div>



<!-- ########################################## FICHE VEHICULE ################################################ -->










<?php
