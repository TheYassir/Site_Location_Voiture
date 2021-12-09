<?php 
require_once 'inc/init.inc.php';
require_once 'inc/nav.inc.php';

$toutagence = $bdd->prepare("SELECT * FROM agences WHERE id_agence = :agence_id");
$toutagence->bindValue(':agence_id', $_SESSION['lacommande']['agence_id'], PDO::PARAM_STR);
$toutagence->execute();
$agence = $toutagence->fetchAll(PDO::FETCH_ASSOC);

$toutvoiture = $bdd->prepare("SELECT * FROM vehicule WHERE id_vehicule = :vehicule_id");
$toutvoiture->bindValue(':vehicule_id', $_SESSION['lacommande']['vehicule_id'], PDO::PARAM_STR);
$toutvoiture->execute();
$voiture = $toutvoiture->fetchAll(PDO::FETCH_ASSOC);

// echo '<pre>'; print_r($_SESSION); echo '</pre>';



// $connectdirect = $bdd->prepare("SELECT * FROM membre WHERE pseudo = :pseudo OR email = :email");
// $connectdirect->bindValue(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
// $connectdirect->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
// $connectdirect->execute();
// $user = $connectdirect->fetch(PDO::FETCH_ASSOC);
// foreach($user as $key => $value){
// if($key != 'password')
// $_SESSION['user'][$key] = $value;
// }

?>
<br>
<div class="container mx-auto text-center my-5 mb-5">
    <h1 class="text-center my-5">FELICITATION !</h1>
    <h4 class="text-center">Votre commande n°<strong class="text-success"><?=$_SESSION['lacommande']['id_commande'] ?></strong> a bien été validée le <?=$_SESSION['lacommande']['date_heure_enregistrement'] ?></h4>
    <p class="text-center">Un mail de confirmation vous a été envoyé.</p>
    <h2 class="text-center my-4">Récapitulatif de votre commande</h2>
    <p class="text-center">Votre véhicule vous attendra au <?= $agence[0]['adresse'] . ", " . ucfirst($agence[0]['ville']) . ", " . $agence[0]['code_postal'] ?></p>
    <p class="text-center mb-5">Le véhicule (<?= ucfirst($voiture[0]['marque']) ?>  <?= ucfirst($voiture[0]['modele']) ?>) que vous avez réservez du <?=$_SESSION['lacommande']['date_heure_depart'] ?> au <?=$_SESSION['lacommande']['date_heure_fin'] ?> </p>
    <a href="-index.php" class="btn btn-dark mx-auto mb-5">Revenir à l'accueil</a>
</div>







<?php 
require_once 'inc/footer.inc.php';