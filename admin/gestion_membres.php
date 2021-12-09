<?php
require_once '../inc/init.inc.php';
require_once '../admin.inc/nav.admin.inc.php';


$all = $bdd->query("SELECT * FROM membre");
$allin = $all->fetchAll(PDO::FETCH_ASSOC);

############################ SUPPRESSION USER#########################

if(isset($_GET['action']) && $_GET['action'] == 'suppression'){
    if(isset($_GET['id_membre']) && !empty($_GET['id_membre'])){
        $deleteGova = $bdd->prepare("DELETE FROM membre WHERE id_membre = :id_membre");
        $deleteGova->bindValue(':id_membre', $_GET['id_membre'], PDO::PARAM_INT);
        $deleteGova->execute();
        header('location: ' . 'gestion_membres.php');
    } else {   
        header('location: ' . 'gestion_membres.php');
    }
}
############################ SUPPRESSION USER #########################


############################ MODIFICATION USER #########################

if(isset($_POST['pseudo']) && isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['email']) && isset($_POST['sexe']) && isset($_POST['statut'])){  
    if(!empty($_POST['pseudo']) && !empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['email']) && !empty($_POST['sexe']) && !empty($_POST['statut'])){    
        if(isset($_GET['action']) && $_GET['action'] == 'modification'){
            if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {  
                
                if(!empty($_POST['password'])){
                    $_POST['password'] = password_hash($_POST['password'], PASSWORD_BCRYPT);
                    $modif1 = $bdd->prepare("UPDATE membre SET password = :password WHERE id_membre = :id_membre");
                    $modif1->bindValue(':id_membre', $_GET['id_membre'], PDO::PARAM_INT);
                    $modif1->bindValue(':password', $_POST['password'], PDO::PARAM_STR);
                    $modif1->execute();
                    $valid2 = true;
                }

                $modif = $bdd->prepare("UPDATE membre SET pseudo = :pseudo, nom = :nom, prenom = :prenom, email = :email , sexe = :sexe, statut = :statut WHERE id_membre = :id_membre");
                $modif->bindValue(':id_membre', $_GET['id_membre'], PDO::PARAM_INT);
                $modif->bindValue(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
                $modif->bindValue(':nom', $_POST['nom'], PDO::PARAM_STR);
                $modif->bindValue(':prenom', $_POST['prenom'], PDO::PARAM_STR);
                $modif->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
                $modif->bindValue(':sexe', $_POST['sexe'], PDO::PARAM_STR);
                $modif->bindValue(':statut', $_POST['statut'], PDO::PARAM_STR);
                $modif->execute();                    
                $valid = true;

                header('location: ' . 'gestion_membres.php'); 
            } else {
                $error = true;
            }
        } else {
            $error = true;
        }
    } else {
        $error = true;
    }
}
############################ MODIFICATION USER #########################



############################ MEMBRE À MODIFIE  #########################

if(isset($_GET['action']) && $_GET['action'] == 'modification'){

    if(isset($_GET['id_membre']) && !empty($_GET['id_membre'])){
        $membreActuel = $bdd->prepare("SELECT * FROM membre WHERE id_membre = :id_membre");
        $membreActuel->bindValue(':id_membre', $_GET['id_membre'], PDO::PARAM_INT);
        $membreActuel->execute();

        if($membreActuel->rowCount()){
            $memb = $membreActuel->fetch(PDO::FETCH_ASSOC);
            $id_memb = (isset($memb['id_membre'])) ? $memb['id_membre'] : '';
            $pseudomemb = (isset($memb['pseudo'])) ? $memb['pseudo'] : '';
            $nommemb = (isset($memb['nom'])) ? $memb['nom'] : '';
            $prenommemb = (isset($memb['prenom'])) ? $memb['prenom'] : '';
            $emailmemb = (isset($memb['email'])) ? $memb['email'] : '';
            $sexememb = (isset($memb['sexe'])) ? $memb['sexe'] : '';
            $statutmemb = (isset($memb['statut'])) ? $memb['statut'] : '';


        } else {
            header('location: ' . 'gestion_membres.php');
        }
    } else {
        header('location: ' . 'gestion_membres.php');
    }
}

// echo '<pre>'; print_r($_POST); echo '</pre>';

############################  MEMBRE À MODIFIE  #########################


?>

<br><br><br>

<div class="container">
    <h1 class="display-4 fst-italic text-center my-5">Les Membres</h1>
    <?php if(isset($valid)): ?>
        <p class="alert alert-success col-12 p-3 text-center mt-3 mx-auto">Vos Modifications ont bien été enregistrée !</p>
    <?php elseif(isset($valid2)): ?>
        <p class="alert alert-success col-12 p-3 text-center mt-3 mx-auto">Vous avez bien changer le mot de passe !</p>
    <?php elseif(isset($error)): ?>
        <p class="alert alert-danger col-12 p-3 text-center mt-3 mx-auto">Formulaire mal rempli !</p>
    <?php endif; ?>

    <table class="mx-auto table table-dark table-striped text-center align-middle mb-5 my-5">
        <thead>
            <tr class="table-danger">
                <?php foreach($allin[0] as $key => $value): ?>
                <?php if($key != 'password'): ?>
                    <?php if($key == 'date_enregistrement'): ?>
                        <th><?php $date = str_replace('_', ' d\'', $key); echo strtoupper($date) ; ?></th>
                    <?php else: ?>
                        <th><?= strtoupper($key); ?></th>
                    <?php endif; ?>
                <?php endif; ?>
                <?php endforeach; ?>
                <th>EDIT</th>
                <th>SUPP</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($allin as $tabo): ?>
            <tr>
                <?php foreach($tabo as $key => $value): ?>
                    <?php if($key != 'password'): ?>
                        <?php if($key == 'nom'): ?>
                            <td><?= strtoupper($value); ?></td>
                        <?php elseif($key == 'prenom'): ?>
                            <td><?= ucfirst($value) ?></td>
                        <?php else: ?>
                            <td><?= $value; ?></td>
                        <?php endif; ?>
                    <?php endif; ?>
                
                <?php endforeach; ?>
                <td><a href="?action=modification&id_membre=<?= $tabo['id_membre'] ?>#ici" class="btn btn-warning"><i class="bi bi-pencil-square"></i></a></td>
                <td><a href="?action=suppression&id_membre=<?= $tabo['id_membre'] ?>" class="btn btn-danger"><i class="bi bi-trash-fill"></i></a></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<br><br><br><br><br><span id="ici"></span>

<?php if(isset($_GET['action']) && $_GET['action'] == 'modification'): ?>

    <h1 class="display-4 fst-italic text-center my-5">Modifications sur le Membre n°<?php if(isset($id_memb)) echo $id_memb; ?></h1>
   
    <form method="post" class="row g-3 my-5 mb-5 container">

        <div class="col-md-12 mt-3 row justify-content-between">
            <div class="col-md-5">
                <label for="pseudo" class="form-label">Pseudo</label>
                <input type="text" class="form-control" id="pseudo" name="pseudo" placeholder="Pseudo" value="<?php if(isset($pseudomemb)) echo ucfirst($pseudomemb); ?>">
            </div>
            <div class="col-md-5">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="<?php if(isset($emailmemb)) echo $emailmemb; ?>">
            </div>
        </div>

        <div class="col-md-12 mt-3 row justify-content-between">
            <div class="col-md-5">
                <label for="password" class="form-label">Nouveau Mot de Passe</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <div class="col-md-5">
                <label for="sexe" class="form-label">Civilité</label>
                <select class="form-select" name="sexe" id="sexe">
                    <option value="femme" <?php if(isset($sexememb) && $sexememb == "femme") echo "selected";?>>Madame</option>
                    <option value="homme" <?php if(isset($sexememb) && $sexememb == "homme") echo "selected";?>>Monsieur</option>
                </select>
            </div>
        </div>

        <div class="col-md-12 mt-3 row justify-content-between">
            <div class="col-md-5">
                <label for="nom" class="form-label">Nom</label>
                <input type="text" class="form-control" id="nom" name="nom" placeholder="Nom" value="<?php if(isset($nommemb)) echo strtoupper($nommemb); ?>">
            </div>
            <div class="col-md-5 ">
                <label for="statut" class="form-label">Statut</label>
                <select class="form-select" name="statut" id="statut">
                    <option value="admin" <?php if(isset($statutmemb) && $statutmemb == "admin") echo "selected";?>>Admin</option>
                    <option value="user" <?php if(isset($statutmemb) && $statutmemb == "user") echo "selected";?>>User</option>
                </select>
            </div>
        </div>

        <div class="col-md-12 mt-3 row justify-content-between">
            <div class="col-md-5 mt-3 mb-5">
                <label for="prenom" class="form-label">Prénom</label>
                <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Prénom" value="<?php if(isset($prenommemb)) echo ucfirst($prenommemb); ?>">
            </div>
        </div>

        <div class="mx-auto col-12 row">
            <button href="gestion_membres.php" type="submit" class="btn btn-dark mx-auto col-5">Enregistrer</button>
        </div>


    </form>







<?php endif; ?>
<?php require_once '../inc/footer.inc.php'; 
