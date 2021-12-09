<?php 
require_once 'inc/init.inc.php';

if(isset($_GET['action']) && $_GET['action'] == 'modification'){
    if(isset($_POST['pseudo']) && isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['email'])){  
        if(!empty($_POST['pseudo']) && !empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['email'])){
            if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {  
                $modif = $bdd->prepare("UPDATE membre SET pseudo = :pseudo, nom = :nom, prenom = :prenom, email = :email WHERE id_membre = :id_membre");
                $modif->bindValue(':id_membre', $_SESSION['user']['id_membre'], PDO::PARAM_INT);
                $modif->bindValue(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
                $modif->bindValue(':nom', $_POST['nom'], PDO::PARAM_STR);
                $modif->bindValue(':prenom', $_POST['prenom'], PDO::PARAM_STR);
                $modif->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
                $modif->execute();

                $_SESSION['user']['pseudo'] = $_POST['pseudo'] ;
                $_SESSION['user']['nom'] = $_POST['nom'] ;
                $_SESSION['user']['prenom'] = $_POST['prenom'] ;
                $_SESSION['user']['email'] = $_POST['email'] ;
                
                
                header('location: profil.php');

            } else {
                $error2 = true;
            }
        } else {
            $error2 = true;
        }
    }
}
require_once 'inc/nav.inc.php';

if(!connect() || isset($_GET['action']) && $_GET['action'] == 'deconnexion')
{
    header('location: -index.php');
}

if(isset($_GET['action']) && $_GET['action'] != 'modification'){
    header('location: profil.php');
}





// echo '<pre>'; print_r($_SESSION); echo '</pre>';

?>

<?php if(isset($_GET['action']) && $_GET['action'] == 'modification'): ?>

<main>
    <form method="post" action="">
        <div class="p-5" style="width:100%; height:1000px; background-image: url('assets/backprofil.jpg'); background-size: cover; background-repeat: no-repeat">
            <div class="card container col-8 text-center border-info mt-5">
                <div class="card-header"><h1 class="text-center my-5">Bonjour <span class="text-info"><?= ucfirst($_SESSION['user']['pseudo']); ?></span></h1></div>
                <div class="card-body">
                <?php if(isset($error2)): ?>
                    <p class="alert alert-danger col-12 p-3 text-center mt-3 mx-auto">Formulaire mal rempli veuilliez recommencer et mieu !</p>
                <?php endif ;?>
                    <h5 class="card-title">Vos données personnelles</h5>
                    <?php foreach($_SESSION['user'] as $key => $value): 
                        if($key != 'id_membre' && $key != 'sexe' && $key != 'statut'):   ?>
                        <?php if($key == 'date_enregistrement'):  ?>
                            <p class="card-text d-flex justify-content-around">
                            <strong>Date d'enregistrement</strong>
                            <span><?= $value ?></span>
                        </p>
                        <?php else: ?>
                        <p class="card-text d-flex justify-content-between">
                            
                            <div class="col-md-12 mt-3 row justify-content-between">
                                <div class="col-md-5">
                                    <strong><?= ucfirst($key); ?></strong>
                                </div>
                                <div class="col-md-5">
                                    <input type="text" class="form-control" id="<?= $key ?>" name="<?= $key ?>" placeholder="<?= $value ?>" value="<?= $value ?>">
                                </div>
                            </div>
                        </p>
                        <?php endif; ?>
                    <?php endif;
                    endforeach; ?>
                </div>
                <div class="card-footer">
                    <div class="mx-auto text-center">
                        <button href="profil.php" type="submit" class="btn btn-outline-info mx-auto my-5 col-4">Enregistrer</button>
                    </div>
                </div>
            </div> 
        </div>
    </form>
</main>

<?php else: ?>

<main>
    <div class="p-5" style="width:100%; height:1000px; background-image: url('assets/backprofil.jpg'); background-size: cover; background-repeat: no-repeat">
        <div class="card container col-8 text-center border-primary mt-5">
            <div class="card-header"><h1 class="text-center my-5">Bonjour <span class="text-primary"><?= ucfirst($_SESSION['user']['pseudo']); ?></span></h1></div>
            <div class="card-body">
                <h5 class="card-title">Vos données personnelles</h5>
                <?php foreach($_SESSION['user'] as $key => $value): 
                    if($key != 'id_membre' && $key != 'sexe' && $key != 'statut'):   ?>
                    <?php if($key == 'date_enregistrement'):  ?>
                        <p class="card-text d-flex justify-content-between">
                        <strong>Date d'enregistrement</strong>
                        <span><?= $value ?></span>
                    </p>
                    <?php else: ?>
                    <p class="card-text d-flex justify-content-between">
                        <strong><?= ucfirst($key); ?></strong>
                        <span><?= $value ?></span>
                    </p>
                    <?php endif; ?>
                <?php endif;
                endforeach; ?>
            </div>
            <div class="card-footer">
                <div class="mx-auto text-center">
                    <a href="profil.php?action=modification" class="btn col-4 btn-outline-primary my-5">Modifier</a>
                </div>
            </div>
        </div>
    </div>
</main>

<?php endif;
require_once 'inc/footer.inc.php';
