<?php
require_once '../inc/init.inc.php';
require_once '../admin.inc/nav.admin.inc.php';
// echo '<pre>'; print_r($_POST); echo '</pre>';

$all = $bdd->query("SELECT * FROM agences");
$allin = $all->fetchAll(PDO::FETCH_ASSOC);


if(isset($_GET['action']) && $_GET['action'] == 'suppression'){
    if(isset($_GET['id_agence']) && !empty($_GET['id_agence'])){
        $deleteGova = $bdd->prepare("DELETE FROM agences WHERE id_agence = :id_agence");
        $deleteGova->bindValue(':id_agence', $_GET['id_agence'], PDO::PARAM_INT);
        $deleteGova->execute();
        header('location: ' . 'gestion_agences.php?action=affichage');
    } else {   
        header('location: ' . 'gestion_agences.php?action=affichage');
    }
}

if(isset($_POST['titre']) && isset($_POST['adresse']) && isset($_POST['ville']) && isset($_POST['code_postal']) && isset($_POST['photo']) && isset($_POST['description'])){  

    if(!empty($_POST['titre']) && !empty($_POST['adresse']) && !empty($_POST['ville']) && !empty($_POST['code_postal']) && !empty($_POST['description'])){    

        if(isset($_GET['action']) && $_GET['action'] == 'modification'){

            if(!empty($_POST['photo'])){
                $modif1 = $bdd->prepare("UPDATE agences SET photo = :photo WHERE id_agence = :id_agence");
                $modif1->bindValue(':id_agence', $_GET['id_agence'], PDO::PARAM_INT);
                $modif1->bindValue(':photo', $_POST['photo'], PDO::PARAM_STR);
                $modif1->execute();
            }
            if(preg_match("#^[0-9]{5}$#",$_POST['code_postal'])) {  
                    $modif = $bdd->prepare("UPDATE agences SET titre = :titre, adresse = :adresse, ville = :ville, code_postal =:code_postal, description = :description WHERE id_agence = :id_agence");
                    $modif->bindValue(':id_agence', $_GET['id_agence'], PDO::PARAM_INT);
                    $modif->bindValue(':titre', $_POST['titre'], PDO::PARAM_STR);
                    $modif->bindValue(':adresse', $_POST['adresse'], PDO::PARAM_STR);
                    $modif->bindValue(':ville', $_POST['ville'], PDO::PARAM_STR);
                    $modif->bindValue(':code_postal', $_POST['code_postal'], PDO::PARAM_INT);
                    $modif->bindValue(':description', $_POST['description'], PDO::PARAM_STR);
                    $modif->execute();
                    $msg = "L'agence a été modifié avec succés.";;
                    
                    header('location: ' . 'gestion_agences.php?action=affichage'); 

            } 
        } else {
                $insert = $bdd->prepare("INSERT INTO agences (titre, adresse, ville, code_postal, description , photo) VALUES (:titre, :adresse, :ville, :code_postal, :description , :photo)");
                $insert->bindValue(':titre', $_POST['titre'], PDO::PARAM_STR);
                $insert->bindValue(':adresse', $_POST['adresse'], PDO::PARAM_STR);
                $insert->bindValue(':ville', $_POST['ville'], PDO::PARAM_STR);
                $insert->bindValue(':code_postal', $_POST['code_postal'], PDO::PARAM_INT);
                $insert->bindValue(':description', $_POST['description'], PDO::PARAM_STR);
                $insert->bindValue(':photo', $_POST['photo'], PDO::PARAM_STR);
                $insert->execute();
                header('location: ' . 'gestion_agences.php?action=affichage'); 
                $valid = true;
            }
        
    } else {
        $error = true;
    }
}
if(isset($_GET['action']) && $_GET['action'] == 'modification'){

    if(isset($_GET['id_agence']) && !empty($_GET['id_agence'])){
        $agenceActuel = $bdd->prepare("SELECT * FROM agences WHERE id_agence = :id_agence");
        $agenceActuel->bindValue(':id_agence', $_GET['id_agence'], PDO::PARAM_INT);
        $agenceActuel->execute();

        if($agenceActuel->rowCount()){
            $agen = $agenceActuel->fetch(PDO::FETCH_ASSOC);
            $id_agen = (isset($agen['id_agence'])) ? $agen['id_agence'] : '';
            $titreagen = (isset($agen['titre'])) ? $agen['titre'] : '';
            $adresseagen = (isset($agen['adresse'])) ? $agen['adresse'] : '';
            $villeagen = (isset($agen['ville'])) ? $agen['ville'] : '';
            $code_postalagen = (isset($agen['code_postal'])) ? $agen['code_postal'] : '';
            $descriptionagen = (isset($agen['description'])) ? $agen['description'] : '';
            $photoagen = (isset($agen['photo'])) ? $agen['photo'] : '';
        }   else {
            header('location: ' . 'gestion_agences.php?action=affichage');
        }
    }   else {
        header('location: ' . 'gestion_agences.php?action=affichage');
    }
}




?>

<div class="container">
<br><br><br>

    <h1 class="display-4 fst-italic text-center my-5">Toutes Nos Agences</h1>

    <table class="mx-auto table table-hover table-striped text-center align-middle">
            <thead>
                <tr class="table-warning">
                    <?php foreach($allin[0] as $key => $value): ?>
                    <?php if($key != 'id_agence'): ?>
                        <?php  if($key == 'code_postal'): ?>
                            <th>CODE&nbsp;POSTAL</th>
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
                        <?php if($key != 'id_agence'): ?>
                            <?php if($key == 'title'): ?>
                                <td><?= strtoupper($value); ?></td>
                                <?php elseif($key == 'photo'): ?>
                                 <td>
                                <img src=" ../assets/<?= $value; ?>" class="img-fluid w-50 h-50"> 
                                </td>
                            <?php elseif($key == 'ville'): ?>
                                <td><?= ucfirst($value) ?></td>
                            <?php else: ?>
                                <td><?= $value; ?></td>
                            <?php endif; ?>
                        <?php endif; ?>
                    
                    <?php endforeach; ?>
                    <td><a href="?action=modification&id_agence=<?= $tabo['id_agence'] ?>#ici" class="btn btn-warning"><i class="bi bi-pencil-square"></i></a></td>
                    <td><a href="?action=suppression&id_agence=<?= $tabo['id_agence'] ?>" class="btn btn-danger"><i class="bi bi-trash-fill"></i></a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
    </table>
           



<br><br><br><br><br><span id="ici"></span>






    <?php if(isset($_GET['action']) && $_GET['action'] == 'modification'): ?>
    <h1 class="display-4 fst-italic text-center my-5">Modifications sur l'agence n°<?php if(isset($id_agen)) echo $id_agen; ?></h1>
    <?php else: ?>
    <h1 class="display-4 fst-italic text-center my-5">Ajout d'agence</h1>
    <?php endif; ?>

    <?php if(isset($error)): ?>
        <p class="alert alert-danger col-12 p-3 text-center mt-3 mx-auto">Formulaire mal rempli veuilliez recommencer et mieu !</p>
    <?php elseif(isset($valid)): ?>
        <p class="alert alert-success col-12 p-3 text-center mt-3 mx-auto">Votre Nouvelle Agence à été enregistrée !</p>
    <?php else: ?>
        <p class="alert alert-secondary col-12 p-3 text-center mt-3 mx-auto">Remplir le formulaire convenablement.</p>
    <?php endif; ?>

    <form method="post" class="row g-3">
        <div class="col-md-12 mt-3">
            <label for="titre" class="form-label">Titre de l'agence</label>
            <input type="text" class="form-control" id="titre" name="titre" value="<?php if(isset($titreagen)) echo $titreagen; ?>">
        </div>
        <div class="col-md-12 mt-3 row">
            <div class="col-md-6">
                <label for="adresse" class="form-label">Adresse</label>
                <input type="text" class="form-control" id="adresse" name="adresse" value="<?php if(isset($adresseagen)) echo $adresseagen; ?>">
            </div>
            <div class="col-md-4">
                <label for="ville" class="form-label">Ville</label>
                <input type="text" class="form-control" id="ville" name="ville" value="<?php if(isset($villeagen)) echo $villeagen; ?>">
            </div>
            <div class="col-md-2">
                <label for="code_postal" class="form-label">Code Postal</label>
                <input type="text" class="form-control" id="code_postal" name="code_postal" value="<?php if(isset($code_postalagen)) echo $code_postalagen; ?>">
            </div>
        </div>
        <div class="col-md-12 row my-3">
            
            
            <div class="col-md-6">
                <label for="photo" class="form-label">Photo du véhicule</label>
                <input type="file" class="form-control" id="photo" name="photo">
            </div>
            <?php if(isset($photoagen) && !empty($photoagen)): ?>
            <input type="hidden" id="photo_actuelle" name="photo_actuelle" value="<?= $photoagen ?>">
            <div class="d-flex flex-column align-items-center col-md-6 row my-3">
                <a href="../assets/<?= $photoagen; ?>" class="d-flex align-items-center">
                    <img src="../assets/<?= $photoagen ?>" alt="" class="img-articles-bo shadow-sm w-50">
                </a>
            </div>
            <?php endif; ?>
            <div class="col-md-6">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="4"><?php if(isset($descriptionagen)) echo $descriptionagen; ?></textarea>
            </div>
            
            
        </div>
        <button href="gestion_agences.php?action=affichage" type="submit" class="btn btn-warning mb-4 col-4 mx-auto">Ajouter</button>
    </form>
</div>






<?php require_once '../inc/footer.inc.php'; 
