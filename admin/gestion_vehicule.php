<?php
require_once '../inc/init.inc.php';
require_once '../admin.inc/nav.admin.inc.php';


$all = $bdd->query("SELECT * FROM vehicule");
$allin = $all->fetchAll(PDO::FETCH_ASSOC);

############################ VILLE SELECTEUR #########################
$data = $bdd->query("SELECT DISTINCT id_agence, ville FROM agences");


############################ VILLE SELECTEUR #########################



if(isset($_GET['action']) && $_GET['action'] == 'suppression'){
    if(isset($_GET['id_vehicule']) && !empty($_GET['id_vehicule'])){
        $deleteGova = $bdd->prepare("DELETE FROM vehicule WHERE id_vehicule = :id_vehicule");
        $deleteGova->bindValue(':id_vehicule', $_GET['id_vehicule'], PDO::PARAM_INT);
        $deleteGova->execute();
        $_GET['action'] = 'affichage';
        $msg = "Le véhicule n° <strong>$_GET[id_vehicule]</strong> a été supprimé avec succés.";
    } else {   
        header('location: ' . 'gestion_vehicule.php?action=affichage');
    }
}

if(isset($_GET['action']) && $_GET['action'] == 'modification'){

    if(isset($_GET['id_vehicule']) && !empty($_GET['id_vehicule'])){
        $govaActuel = $bdd->prepare("SELECT * FROM vehicule WHERE id_vehicule = :id_vehicule");
        $govaActuel->bindValue(':id_vehicule', $_GET['id_vehicule'], PDO::PARAM_INT);
        $govaActuel->execute();

        if($govaActuel->rowCount()){
            $gova = $govaActuel->fetch(PDO::FETCH_ASSOC);
            $id_gova = (isset($gova['id_vehicule'])) ? $gova['id_vehicule'] : '';
            $agenceGova = (isset($gova['agence_id'])) ? $gova['agence_id'] : '';
            $marqueGova = (isset($gova['marque'])) ? $gova['marque'] : '';
            $modeleGova = (isset($gova['modele'])) ? $gova['modele'] : '';
            $titreGova = (isset($gova['titre'])) ? $gova['titre'] : '';
            $descriptionGova = (isset($gova['description'])) ? $gova['description'] : '';
            $photoGova = (isset($gova['photo'])) ? $gova['photo'] : '';
            $prix_journalierGova = (isset($gova['prix_journalier'])) ? $gova['prix_journalier'] : '';
        }   else {
            header('location: ' . 'gestion_vehicule.php?action=affichage');
        }
    }   else {
        header('location: ' . 'gestion_vehicule.php?action=affichage');
    }
}



if(isset($_POST['agence_id']) && isset($_POST['marque']) && isset($_POST['modele']) && isset($_POST['titre']) && isset($_POST['prix_journalier']) && isset($_POST['description'])){  
    if(!empty($_POST['agence_id']) && !empty($_POST['marque']) && !empty($_POST['modele']) && !empty($_POST['titre']) && !empty($_POST['prix_journalier']) && !empty($_POST['description'])){    
        
        if(preg_match("#^[0-9]{3}$#",$_POST['prix_journalier']) && preg_match("#^[0-9]#",$_POST['agence_id'])) {  
            if(isset($_GET['action']) && $_GET['action'] == 'modification'){
                $modif = $bdd->prepare("UPDATE vehicule SET agence_id = :agence_id, marque = :marque, modele = :modele, titre = :titre, prix_journalier = :prix_journalier, description = :description WHERE id_vehicule = :id_vehicule");
                $modif->bindValue(':id_vehicule', $_GET['id_vehicule'], PDO::PARAM_INT);
                $modif->bindValue(':agence_id', $_POST['agence_id'], PDO::PARAM_INT);
                $modif->bindValue(':marque', $_POST['marque'], PDO::PARAM_STR);
                $modif->bindValue(':modele', $_POST['modele'], PDO::PARAM_STR);
                $modif->bindValue(':titre', $_POST['titre'], PDO::PARAM_STR);
                $modif->bindValue(':prix_journalier', $_POST['prix_journalier'], PDO::PARAM_INT);
                $modif->bindValue(':description', $_POST['description'], PDO::PARAM_STR);
                $modif->execute();
                $msg = "Le véhicule a été modifié avec succés.";;
                
                if(!empty($_POST['photo'])){
                    $modif1 = $bdd->prepare("UPDATE vehicule SET photo = :photo WHERE id_vehicule = :id_vehicule");
                    $modif1->bindValue(':id_vehicule', $_GET['id_vehicule'], PDO::PARAM_INT);
                    $modif1->bindValue(':photo', $_POST['photo'], PDO::PARAM_STR);
                    $modif1->execute();
                }
                header('location: ' . 'gestion_vehicule.php?action=affichage'); 

            } else {
                $insert = $bdd->prepare("INSERT INTO vehicule (agence_id, marque, modele, titre, prix_journalier, photo, description) VALUES (:agence_id, :marque, :modele, :titre, :prix_journalier, :photo, :description)");
                $insert->bindValue(':agence_id', $_POST['agence_id'], PDO::PARAM_INT);
                $insert->bindValue(':marque', $_POST['marque'], PDO::PARAM_STR);
                $insert->bindValue(':modele', $_POST['modele'], PDO::PARAM_STR);
                $insert->bindValue(':titre', $_POST['titre'], PDO::PARAM_STR);
                $insert->bindValue(':photo', $_POST['photo'], PDO::PARAM_STR);
                $insert->bindValue(':prix_journalier', $_POST['prix_journalier'], PDO::PARAM_INT);
                $insert->bindValue(':description', $_POST['description'], PDO::PARAM_STR);
                $insert->execute();
                $valid = true;
            }
        } else {
             $error = true;
        }
    } else {
        $error = true;
    }
}
// // echo '<pre>'; print_r($_POST); echo '</pre>';



?>
<br>
<br>
<div class="d-flex mx-auto mt-2 mb-5 justify-content-center">
    <a href="?action=affichage" class="btn btn-outline-primary px-3">Affichage des véhicules</a>
    &nbsp;&nbsp;
    <a href="?action=ajout" class="btn btn-outline-info px-4">Ajout de véhicule</a>
    &nbsp;&nbsp;
</div>

<?php if(isset($_GET['action']) && $_GET['action'] == 'ajout' || isset($_GET['action']) && $_GET['action'] == 'modification'): ?>
    <?php if(isset($_GET['action']) && $_GET['action'] == 'modification'): ?>
    <h1 class="display-4 fst-italic text-center my-5">Modifications sur le véhicule n°<?php if(isset($id_gova)) echo $id_gova; ?></h1>
    <?php else: ?>
    <h1 class="display-4 fst-italic text-center my-5">Ajout de véhicule</h1>
    <?php endif; ?>

<div class="container">
    <?php if(isset($error)): ?>
        <p class="alert alert-danger col-12 p-3 text-center mt-3 mx-auto">Formulaire mal rempli veuilliez recommencer et mieu !</p>
    <?php elseif(isset($valid)): ?>
        <p class="alert alert-success col-12 p-3 text-center mt-3 mx-auto">Votre annonce à été enregistrée !</p>
        <?php elseif(isset($valid2)): ?>
        <p class="alert alert-success col-12 p-3 text-center mt-3 mx-auto">Votre véhicule à bien été modifié !</p>
    <?php else: ?>
        <p class="alert alert-secondary col-12 p-3 text-center mt-3 mx-auto">Remplir le formulaire convenablement.</p>
    <?php endif; ?>
    <form method="post" class="row g-3">
        <div class="col-md-6">
            <label for="agence_id" class="form-label">Agence</label>
            <select id="agence_id" name="agence_id" class="form-select">
                <?php while($vil = $data->fetch(PDO::FETCH_ASSOC)): ?>
                <option value="<?= $vil['id_agence'] ?>"<?php if(isset($agenceGova) && $agenceGova == "$vil[id_agence]") echo 'selected'; ?>><?= ucfirst($vil['ville']); ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="col-md-6">
            <label for="marque" class="form-label">Marque</label>
            <select id="marque" name="marque" class="form-select">
                <option value="bmw" <?php if(isset($marqueGova) && $marqueGova == 'bmw') echo 'selected'; ?>>BMW</option>
                <option value="peugeot" <?php if(isset($marqueGova) && $marqueGova == 'peugeot') echo 'selected'; ?>>Peugeot</option>
                <option value="audi" <?php if(isset($marqueGova) && $marqueGova == 'audi') echo 'selected'; ?>>Audi</option>
                <option value="mercedes" <?php if(isset($marqueGova) && $marqueGova == 'mercedes') echo 'selected'; ?>>Mercedes</option>
                <option value="renault" <?php if(isset($marqueGova) && $marqueGova == 'renault') echo 'selected'; ?>>Renault</option>
                <option value="aston_martin" <?php if(isset($marqueGova) && $marqueGova == 'aston_martin') echo 'selected'; ?>>Aston Martin</option>
                <option value="volkswagen" <?php if(isset($marqueGova) && $marqueGova == 'volkswagen') echo 'selected'; ?>>Volkwagen</option>

            </select>
        </div>
        <div class="col-md-12">
            <label for="modele" class="form-label">Modèle du véhicule</label>
            <input type="text" class="form-control" id="modele" name="modele" value="<?php if(isset($modeleGova)) echo $modeleGova; ?>">
        </div>
        <div class="col-md-12">
            <label for="titre" class="form-label">Titre de l'annonce</label>
            <input type="text" class="form-control" id="titre" name="titre" value="<?php if(isset($titreGova)) echo $titreGova; ?>">
        </div>
        <div class="col-md-6">
            <label for="prix_journalier" class="form-label">Prix journalier</label>
            <input type="text" class="form-control" id="prix_journalier" name="prix_journalier" value="<?php if(isset($prix_journalierGova)) echo $prix_journalierGova; ?>">
        </div>
        <div class="col-md-6">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="4"><?php if(isset($descriptionGova)) echo $descriptionGova; ?></textarea>
        </div>
        <div class="col-md-12 row">
            <div class="col-md-6">
                <label for="photo" class="form-label">Photo du véhicule</label>
                <input type="file" class="form-control" id="photo" name="photo" value="<?= $photoGova ?>">
            </div>
            <?php if(isset($photoGova) && !empty($photoGova)): ?>
            <input type="hidden" id="photo_actuelle" name="photo_actuelle" value="<?= $photoGova ?>">
            <div class="d-flex flex-column align-items-center col-md-6 row my-3">
                <a href="../assets/<?= $photoGova; ?>" class="d-flex align-items-center">
                    <img src="../assets/<?= $photoGova ?>" alt="" class="img-articles-bo shadow-sm w-50">
                </a>
            </div>
            <?php endif; ?>
        </div>
        <?php if($_GET['action'] == 'modification'): ?>
        <button type="submit" class="btn btn-success mb-4 col-6 mx-auto">Enregistrer les Modifications</button>
        <?php else: ?>
        <button type="submit" class="btn btn-success mb-4 col-6 mx-auto">Ajouter</button>
        <?php endif; ?>
    </form>
</div>
<?php require_once '../inc/footer.inc.php'; ?>
<?php endif; ?>

<?php if(isset($_GET['action']) && $_GET['action'] == 'affichage'): ?>
<div class="container my-5">
    <h1 class="text-center my-5">Toutes nos Annonces</h1>
    <?php if(isset($msg)): ?>
        <p class="bg-success col-md-5 mx-auto p-3 text-center text-white my-3 shadow-sm"><?= $msg; ?></p>
    <?php endif; ?>
    <table class="mx-auto table table-hover table-striped text-center">
            <thead>
                <tr class="table-primary">
                <th>AGENCE</th>
                    <?php foreach($allin[0] as $key => $value): ?>
                    <?php if($key != 'id_vehicule'): ?>
                        <?php if($key != 'agence_id'): ?>
                            <?php if($key == 'prix_journalier'): ?>
                                <th>PRIX&nbsp;/&nbsp;JOUR</th>
                                <?php else: ?>
                                    <th><?= strtoupper($key); ?></th>
                            <?php endif; ?>
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
                        <?php if($key != 'id_vehicule' && $key != 'reservation_message'): ?>
                            <?php if($key == 'title'): ?>
                                <td><?= strtoupper($value); ?></td>
                            <?php elseif($key == 'agence_id'): ?>
                                <?php $villeGova = $bdd->prepare("SELECT ville FROM agences WHERE id_agence = :agence_id");
                                $villeGova->bindValue(':agence_id', $value, PDO::PARAM_INT);
                                $villeGova->execute();
                                $villeGova1 = $villeGova->fetch(PDO::FETCH_ASSOC);
                                ?>                                                        
                                <td><?= $villeGova1['ville']; ?></td>
                            <?php elseif($key == 'photo'): ?>
                                    <td>
                                    <img src=" ../assets/<?= $value; ?>" class="img-fluid w-50"> 

                                            <!-- <img src="" alt="" class="img-articles-bo"> -->

                                        </td>
                            <?php elseif($key == 'prix_journalier'): ?>
                                <td><?= $value . " €" ;?></td>
                            <?php elseif($key == 'marque'): ?>
                                <td><?= ucfirst($value) ?></td>
                            <?php else: ?>
                                <td><?= $value; ?></td>
                            <?php endif; ?>
                        <?php endif; ?>
                    
                    <?php endforeach; ?>
                    <td><a href="?action=modification&id_vehicule=<?= $tabo['id_vehicule'] ?>" class="btn btn-warning"><i class="bi bi-pencil-square"></i></a></td>
                    <td><a href="?action=suppression&id_vehicule=<?= $tabo['id_vehicule'] ?>" class="btn btn-danger"><i class="bi bi-trash-fill"></i></a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
    </table>
            </div>
            <?php require_once '../inc/footer.inc.php'; ?>
            <?php endif; ?>
            <?php if(empty($_GET['action'])): ?>
                <div class="container"></div>
                <p class="alert alert-secondary col-6 p-3 text-center mt-3 mx-auto">Que Voulez-Vous Faire ?</p>
                </div>

                </main>
                <footer class="py-5 bg-dark fixed-bottom">
                    <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Your Website 2021</p></div>
                </footer>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
                <script src="js/scripts.js"></script>
            </body>
        </html>
    <?php endif; ?>
