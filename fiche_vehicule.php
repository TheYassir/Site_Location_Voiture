<?php 
require_once 'inc/init.inc.php';

################################# RECUPERATION DE LA VOITURE A PARTIR DE L URL #########################
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
            header('location: ' . '-index.php');
        }
    }   else {
        header('location: ' . '-index.php');
    }

################################# RECUPERATION DE LA VOITURE A PARTIR DE L URL #########################
// echo '<pre>'; print_r($_POST); echo '</pre>';

// echo '<pre>'; print_r($_SESSION); echo '</pre>';

// echo '<pre>'; print_r($prixTotal); echo '</pre>';

if(isset($_POST['date_heure_depart']) && isset($_POST['date_heure_fin'])){  
    if(!empty($_POST['date_heure_depart']) && !empty($_POST['date_heure_fin']) ){  

        $date_debut = strtotime($_POST['date_heure_depart']); 
        $date_fin = strtotime($_POST['date_heure_fin']); 
        $prixTotal = round(($date_fin - $date_debut)/60/60/24,0) * $prix_journalierGova ;  

        $insert = $bdd->prepare("INSERT INTO commande (membre_id, vehicule_id, agence_id, date_heure_depart, date_heure_fin , prix_total, date_heure_enregistrement) VALUES (:membre_id, :vehicule_id, :agence_id, :date_heure_depart, :date_heure_fin , :prix_total, NOW() )");
        $insert->bindValue(':membre_id', $_SESSION['user']['id_membre'], PDO::PARAM_INT);
        $insert->bindValue(':vehicule_id',  $id_gova, PDO::PARAM_INT);
        $insert->bindValue(':agence_id', $agenceGova, PDO::PARAM_INT);
        $insert->bindValue(':date_heure_depart', $_POST['date_heure_depart'], PDO::PARAM_STR);
        $insert->bindValue(':date_heure_fin', $_POST['date_heure_fin'], PDO::PARAM_STR);
        $insert->bindValue(':prix_total', $prixTotal, PDO::PARAM_INT);
        $insert->execute();

        $lacommande = $bdd->prepare("SELECT * FROM commande WHERE date_heure_depart = :date_heure_depart OR date_heure_fin = :date_heure_fin");
        $lacommande->bindValue(':date_heure_depart', $_POST['date_heure_depart'], PDO::PARAM_STR);
        $lacommande->bindValue(':date_heure_fin', $_POST['date_heure_fin'], PDO::PARAM_STR);
        $lacommande->execute();

        $comenses = $lacommande->fetch(PDO::FETCH_ASSOC);
        foreach($comenses as $key => $value){
            if($key != 'password')
            $_SESSION['lacommande'][$key] = $value;
        }
        header('location: ' . 'validation.php'); 
        $valid = true;
    } else {
        $error3 = true;
    }
}
require_once 'inc/nav.inc.php';

?>


<br><br>
<?php if(isset($_GET['id_vehicule']) && !empty($_GET['id_vehicule'])) :?>
<div class="container mx-auto mb-5 col-6">
    <div class="card shadow-sm mx-auto my-5 mt-5 border-warning" style="border-radius: 21px;">
        <img src="<?php URL ?>assets/<?= $photoGova?>" class="card-img-top mx-auto img-fluid" alt="" style="width: 710px; height: 444px; border-radius: 21px ;">
        <div class="card-body text-center">
            <h5 class="card-title"><?= $titreGova?></h5>
            <p class="card-text"><?= ucfirst($marqueGova)?></p>
            <p class="card-text"><?= $modeleGova?></p>
            <p class="card-text"><?= $descriptionGova?></p>
            <p class="card-text"><?= $prix_journalierGova?> € par jour</p>

            <a href="#" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#fichevec">Choisir vos dates</a>
        </div>
    </div>
    <a href="-index.php" class="btn btn-dark">Revenir à l'accueil</a>

</div>

<?php endif;
require_once 'inc/footer.inc.php';
