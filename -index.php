<?php 
require_once 'inc/init.inc.php';
require_once 'inc/nav.inc.php';

############################ FILTRE AGENCE VOITURE CARD #########################
if(isset($_POST['ville']) && !empty($_POST['ville']) && isset($_POST['date_heure_depart']) && !empty($_POST['date_heure_depart']) && isset($_POST['date_heure_fin']) && !empty($_POST['date_heure_fin']) )
{
    if ($_POST['ville'] == 'all')
    {
        $data4 = $bdd->prepare("SELECT * FROM commande WHERE NOT ((:date_heure_depart BETWEEN date_heure_depart AND date_heure_fin AND :date_heure_fin BETWEEN date_heure_depart AND date_heure_fin) OR (:date_heure_depart < date_heure_depart AND :date_heure_fin BETWEEN date_heure_depart AND date_heure_fin) OR (:date_heure_depart BETWEEN date_heure_depart AND date_heure_fin AND :date_heure_fin > date_heure_fin))");
        $data4->bindValue(':date_heure_depart', $_POST['date_heure_depart'], PDO::PARAM_STR);
        $data4->bindValue(':date_heure_fin', $_POST['date_heure_fin'], PDO::PARAM_STR);
        $data4->execute();
        $finalvil4 = $data4->fetchAll(PDO::FETCH_ASSOC);
        $requete = "SELECT DISTINCT * FROM vehicule WHERE NOT id_vehicule IN (";
        // $finalvil4 = $data4->fetchAll(PDO::FETCH_ASSOC);
        $ids = [];
        foreach ($finalvil4 as $tabo => $tab){
            foreach ($tab as $key => $value){
                if($key == 'vehicule_id') 
                array_push($ids, $value);
                // $finalvil4['vehicule_id'];
            }
        }
        $id_string = implode(',',$ids);
        $requete .= $id_string;
        // echo '<pre>'; print_r($id_string); echo '</pre>';
        $requete .= ")";
        // echo '<pre>'; print_r($requete); echo '</pre>';
        $all4 = $bdd->query($requete);
    }
    else 
    {
    $recup = $bdd->prepare("SELECT id_agence FROM agences WHERE ville = :ville");
    $recup->bindValue(':ville', $_POST['ville'], PDO::PARAM_STR);
    $recup->execute();
    $recupId = $recup->fetch(PDO::FETCH_ASSOC);
    // echo '<pre>'; print_r($recupId); echo '</pre>';


    $data4 = $bdd->prepare("SELECT * FROM commande WHERE agence_id = :id_agence AND NOT ((:date_heure_depart BETWEEN date_heure_depart AND date_heure_fin AND :date_heure_fin BETWEEN date_heure_depart AND date_heure_fin) OR (:date_heure_depart < date_heure_depart AND :date_heure_fin BETWEEN date_heure_depart AND date_heure_fin) OR (:date_heure_depart BETWEEN date_heure_depart AND date_heure_fin AND :date_heure_fin > date_heure_fin))");
    $data4->bindValue(':date_heure_depart', $_POST['date_heure_depart'], PDO::PARAM_STR);
    $data4->bindValue(':date_heure_fin', $_POST['date_heure_fin'], PDO::PARAM_STR);
    $data4->bindValue(':id_agence', $recupId['id_agence'], PDO::PARAM_INT);
    $data4->execute();
    $finalvil4 = $data4->fetchAll(PDO::FETCH_ASSOC);

    //  echo '<pre>'; print_r($finalvil4); echo '</pre>';

    // $all4 = $bdd->prepare("SELECT * FROM vehicule WHERE id_vehicule = :vehicule_id");
    // $all4->bindValue(':vehicule_id', $finalvil4['vehicule_id'], PDO::PARAM_INT);
    // $all4->execute();
    $agen = $recupId['id_agence'];
    // echo '<pre>'; print_r($agen); echo '</pre>';

    $requete = "SELECT * FROM vehicule WHERE agence_id = $agen AND NOT id_vehicule IN (";
    // $finalvil4 = $data4->fetchAll(PDO::FETCH_ASSOC);
    $ids = [0];
    foreach ($finalvil4 as $tabo => $tab){
        foreach ($tab as $key => $value){
            if($key == 'vehicule_id') 
            array_push($ids, $value);
            // $finalvil4['vehicule_id'];
        }
    }
    $id_string = implode(',',$ids);
    $requete .= $id_string;
    // echo '<pre>'; print_r($id_string); echo '</pre>';
    $requete .= ")";
    // echo '<pre>'; print_r($requete); echo '</pre>';
    $all4 = $bdd->query($requete);
    // echo '<pre>'; print_r($all4); echo '</pre>';
    }

}   elseif(isset($_POST['date_heure_depart']) && !empty($_POST['date_heure_depart']) && isset($_POST['date_heure_fin']) && !empty($_POST['date_heure_fin']) ){
        $data3 = $bdd->prepare("SELECT * FROM commande WHERE ((:date_heure_depart BETWEEN date_heure_depart AND date_heure_fin AND :date_heure_fin BETWEEN date_heure_depart AND date_heure_fin) OR (:date_heure_depart < date_heure_depart AND :date_heure_fin BETWEEN date_heure_depart AND date_heure_fin) OR (:date_heure_depart BETWEEN date_heure_depart AND date_heure_fin AND :date_heure_fin > date_heure_fin))");
        $data3->bindValue(':date_heure_depart', $_POST['date_heure_depart'], PDO::PARAM_STR);
        $data3->bindValue(':date_heure_fin', $_POST['date_heure_fin'], PDO::PARAM_STR);
        $data3->execute();
        // $finalvil3 = $data3->fetchAll(PDO::FETCH_ASSOC);
        $requete = 'SELECT DISTINCT * FROM vehicule WHERE NOT id_vehicule IN (';
        $finalvil3 = $data3->fetchAll(PDO::FETCH_ASSOC);
        $ids = [];
        foreach ($finalvil3 as $tabo => $tab){
            foreach ($tab as $key => $value){
                if($key == 'vehicule_id') 
                array_push($ids, $value);
                // $finalvil3['vehicule_id'];
            }
        }
        $id_string = implode(',',$ids);
        $requete .= $id_string;
        // echo '<pre>'; print_r($id_string); echo '</pre>';
        $requete .= ")";
        // echo '<pre>'; print_r($requete); echo '</pre>';
        $all4 = $bdd->query($requete);

}   elseif(isset($_POST['ville']) && !empty($_POST['ville'])){
        if ($_POST['ville'] == 'all')
        {
            $all2 = $bdd->query("SELECT * FROM vehicule");
        }
        else 
        {
        $data2 = $bdd->prepare("SELECT id_agence FROM agences WHERE ville = :ville");
        $data2->bindValue(':ville', $_POST['ville'], PDO::PARAM_STR);
        $data2->execute();
        $finalvil = $data2->fetch(PDO::FETCH_ASSOC);
            // echo '<pre>'; print_r($finalvil); echo '</pre>';
        $all2 = $bdd->prepare("SELECT * FROM vehicule WHERE agence_id = :id_agence");
        $all2->bindValue(':id_agence', $finalvil['id_agence'], PDO::PARAM_INT);
        $all2->execute();
        }
}

############################ FILTRE AGENCE VOITURE CARD #########################

// echo '<pre>'; print_r($all2); echo '</pre>';


// $lacommande = $bdd->prepare("SELECT * FROM commande WHERE date_heure_depart = :date_heure_depart OR date_heure_fin = :date_heure_fin");
// $lacommande->bindValue(':date_heure_depart', $_POST['date_heure_depart'], PDO::PARAM_STR);
// $lacommande->bindValue(':date_heure_fin', $_POST['date_heure_fin'], PDO::PARAM_STR);
// $lacommande->execute();

// $comenses = $lacommande->fetch(PDO::FETCH_ASSOC);
// foreach($comenses as $key => $value){
//     if($key != 'password')
//     $_SESSION['lacommande'][$key] = $value;
//     }
// $valid = true;
// } else {
// $error3 = true;
// }


############################ CARD VOITURE #########################

$all = $bdd->query("SELECT * FROM vehicule");
$i = 0 ; 
############################ CARD VOITURE #########################




############################ VILLE SELECTEUR #########################
$data = $bdd->query("SELECT DISTINCT ville FROM agences");
############################ VILLE SELECTEUR #########################


// if(isset($_GET['ville']) && !empty($_GET['ville']))
// {
//     $r = $bdd->prepare("SELECT * FROM agence WHERE ville = :ville");
//     $r->bindValue(':ville', $_GET['ville'], PDO::PARAM_STR);
//     $r->execute();

//     if(!$r->rowCount())
//     {
//         header('location: -index.php');
//     }
// }
// else
// {
//     $r = $bdd->query("SELECT * FROM agences");
// }


?>
    <header class="py-5 position-relative" style="width:100%; height:800px; background-image: url('assets/background.jpg'); background-size: cover; background-repeat: no-repeat">
            <div class="text-center my-5">
                <h1 class="text-white fs-3 fw-bolder">Bienvenue à bord</h1>
                <p class="text-white-50 mb-0">Location de voiture 24h/24 et 7j/7</p>
            </div>
            <div class="position-absolute start-50 translate-middle mx-auto disp">
                <form method="post" class="d-flex mx-auto" action="#la">
                    <div class="p-3 mia">
                        <p class="pb-1">Adresse&nbsp;de&nbsp;départ</p>
                        <select  class="form-select my-auto" name="ville" id="ville">
                            <option value="all">Les Agences</option>
                        <?php while($vil = $data->fetch(PDO::FETCH_ASSOC)): ?>
                        <option value="<?= $vil['ville'] ?>"><?= ucfirst($vil['ville']); ?></option>
                        <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="p-3 mia">
                        <p class="pb-1">Début de location</p>
                        <input id="datepicker1" type="datetime-local" class="form-control" name="date_heure_depart">
                    </div>
                    <div class="p-3 mia">
                        <p class="pb-1">Fin de location</p>
                        <input id="datepicker2" type="datetime-local" class="form-control" name="date_heure_fin">
                    </div>
                    <div class="mia2">
                        <button href="#la" type="submit" class="btn mia2 py-5 text-white">Valider&nbsp;un&nbsp;véhicule</button>
                    </div>
                    
                        <p class="text-white"id="text"></p>
                   


                </form>
            </div>
        </header>     
    <main id="la">


    <?php if(isset($_POST['ville']) && !empty($_POST['ville']) || isset($_POST['date_heure_depart']) && !empty($_POST['date_heure_depart']) || isset($_POST['date_heure_fin']) && !empty($_POST['date_heure_fin']) ): ?>
    <?php if(isset($_POST['ville']) && !empty($_POST['ville']) && isset($_POST['date_heure_depart']) && !empty($_POST['date_heure_depart']) && isset($_POST['date_heure_fin']) && !empty($_POST['date_heure_fin']) ): ?>
        <?php $all = $all4 ;?>
    <?php elseif(!empty($_POST['date_heure_depart']) && !empty($_POST['date_heure_fin'])) : ?>
        <?php $all = $all3 ;?>
    <?php  elseif(!empty($_POST['ville'])) : ?>
        <?php $all = $all2 ;?>
    <?php endif ; ?>
    <?php while($car = $all->fetch(PDO::FETCH_ASSOC)):?>
            <?php   $villeGova = $bdd->prepare("SELECT ville FROM agences WHERE id_agence = :agence_id");
                    $villeGova->bindValue(':agence_id', $car['agence_id'], PDO::PARAM_INT);
                    $villeGova->execute();
                    $villeGova1 = $villeGova->fetch(PDO::FETCH_ASSOC); ?>                   
                <?php $i ++ ; ?>
            <div class="d-md-flex flex-md-equal mx-auto w-100 my-md-3 ps-md-3 row row-cols-1 row-cols-md-2 row-cols-lg-3 align-items-between container d-flex justify-content-center">

                <?php if($i % 2 == 0 ): ?>
                
                    <div class="bg-dark me-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center text-white overflow-hidden">
                        <div class="my-3 py-3">
                            <h2 class="display-5"><?= $car['titre'] ?></h2>
                            <p class="lead">Agence de <?= $villeGova1['ville']; ?></p>
                            <p class=""><?= ucfirst($car['prix_journalier'])?> € par jour</p>
                        </div>
                        <div class="bg-light shadow-sm mx-auto" style="background-image: url('assets/<?= $car['photo'];?>'); background-size: cover; width: 78%; height: 168px; border-radius: 21px 21px 0 0;"></div>
                    </div>

                    <div class="bg-light me-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center overflow-hidden">
                        <div class="mx-3 p-3">
                            <h2 class="display-5"><?php $marque = str_replace('_', ' ', $car['marque']); echo ucfirst($marque) ; ?></h2>
                            <p class="lead"><?php $modele = str_replace(' ', '&nbsp;', $car['modele']); echo ucfirst($modele) ; ?></p>
                            <p class=""><?= $car['description'] ?></p>

                        </div>
                        <div class="bg-dark shadow-sm mx-auto" style="width: 78%; height: 200px; border-radius: 21px 21px 0 0;">
                        <?php if(!connect()): ?>
                            <button type="button" class="btn btn-outline-light my-5 py-5" data-bs-toggle="modal" data-bs-target="#staticBackdrop1">En savoir plus</button>
                        <?php else : ?>
                            <a href="fiche_vehicule.php?id_vehicule=<?= $car['id_vehicule'];?>" type="button" class="btn btn-outline-light my-5 py-5">En savoir plus</a>
                        <?php endif ; ?>
                        </div>
                    </div>

                <?php else : ?>

                    <div class="bg-light me-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center overflow-hidden">
                        <div class="my-3 p-3">
                            <h2 class="display-5"><?= $car['titre'] ?></h2>
                            <p class="lead">Agence de <?= $villeGova1['ville']; ?></p>
                            <p class=""><?= ucfirst($car['prix_journalier'])?> € par jour</p>

                        </div>
                        <div class="bg-dark shadow-sm mx-auto" style="background-image: url('assets/<?= $car['photo'];?>'); background-size: cover ; width: 78%; height: 168px; border-radius: 21px 21px 0 0;"></div>
                    </div>

                    <div class="bg-dark me-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center text-white overflow-hidden">
                        <div class="my-3 py-3">
                            <h2 class="display-5"><?php $marque = str_replace('_', '&nbsp;', $car['marque']); echo ucfirst($marque) ; ?></h2>
                            <p class="lead"><?php $modele = str_replace(' ', '&nbsp;', $car['modele']); echo ucfirst($modele) ; ?></p>
                            <p class=""><?= $car['description'] ?></p>
                        </div>
                        <div class="bg-light shadow-sm mx-auto" style="width: 78%; height: 200px; border-radius: 21px 21px 0 0;">
                        <?php if(!connect()): ?>
                            <button type="button" class="btn btn-outline-dark my-5 py-5" data-bs-toggle="modal" data-bs-target="#staticBackdrop1">En savoir plus</button>
                        <?php else : ?>
                            <a href="fiche_vehicule.php?id_vehicule=<?= $car['id_vehicule'];?>" type="button" class="btn btn-outline-dark my-5 py-5">En savoir plus</a>
                        <?php endif ; ?>
                        </div>
                    </div>

                <?php endif ; ?>
            </div>
            <?php endwhile; ?>

<?php else : ?>
    
            <?php while($car = $all->fetch(PDO::FETCH_ASSOC)): ?>
                <?php $villeGova = $bdd->prepare("SELECT ville FROM agences WHERE id_agence = :agence_id");
                    $villeGova->bindValue(':agence_id', $car['agence_id'], PDO::PARAM_INT);
                    $villeGova->execute();
                    $villeGova1 = $villeGova->fetch(PDO::FETCH_ASSOC);
                    ?>                                                        
                <?php $i ++ ; ?>


            <div class="d-md-flex flex-md-equal mx-auto w-100 my-md-3 ps-md-3 row row-cols-1 row-cols-md-2 row-cols-lg-3 align-items-between container d-flex justify-content-center">

                <?php if($i % 2 == 0 ): ?>
                
                    <div class="bg-dark me-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center text-white overflow-hidden">
                        <div class="my-3 py-3">
                            <h2 class="display-5"><?= $car['titre'] ?></h2>
                            <p class="lead">Agence de <?= $villeGova1['ville']; ?></p>
                            <p class=""><?= ucfirst($car['prix_journalier'])?> € par jour</p>
                        </div>
                        <div class="bg-light shadow-sm mx-auto" style="background-image: url('assets/<?= $car['photo'];?>'); background-size: cover; width: 78%; height: 168px; border-radius: 21px 21px 0 0;"></div>
                    </div>

                    <div class="bg-light me-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center overflow-hidden">
                        <div class="mx-3 p-3">
                            <h2 class="display-5"><?php $marque = str_replace('_', ' ', $car['marque']); echo ucfirst($marque) ; ?></h2>
                            <p class="lead"><?php $modele = str_replace(' ', '&nbsp;', $car['modele']); echo ucfirst($modele) ; ?></p>
                            <p class="text-center"><?= $car['description'] ?></p>

                        </div>
                        <div class="bg-dark shadow-sm mx-auto" style="width: 78%; height: 200px; border-radius: 21px 21px 0 0;"><a href="fiche_vehicule.php?id_vehicule=<?= $car['id_vehicule'];?>" type="button" class="btn btn-outline-light my-5 py-5">En savoir plus</a></div>
                    </div>

                <?php else : ?>

                    <div class="bg-light me-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center overflow-hidden">
                        <div class="my-3 p-3">
                            <h2 class="display-5"><?= $car['titre'] ?></h2>
                            <p class="lead">Agence de <?= $villeGova1['ville']; ?></p>
                            <p class=""><?= ucfirst($car['prix_journalier'])?> € par jour</p>

                        </div>
                        <div class="bg-dark shadow-sm mx-auto" style="background-image: url('assets/<?= $car['photo'];?>'); background-size: cover ; width: 78%; height: 168px; border-radius: 21px 21px 0 0;"></div>
                    </div>

                    <div class="bg-dark me-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center text-white overflow-hidden">
                        <div class="my-3 py-3">
                            <h2 class="display-5"><?= ucfirst($car['marque']) ?></h2>
                            <p class="lead"><?php $modele = str_replace(' ', '&nbsp;', $car['modele']); echo ucfirst($modele) ; ?></p>
                            <p class="text-center"><?= $car['description'] ?></p>
                        </div>
                        <div class="bg-light shadow-sm mx-auto" style="width: 78%; height: 200px; border-radius: 21px 21px 0 0;"><a href="fiche_vehicule.php?id_vehicule=<?= $car['id_vehicule'];?>" type="button" class="btn btn-outline-dark my-5 py-5">En savoir plus</a></div>
                    </div>

                <?php endif ; ?>
            </div>
            <?php endwhile; ?>
            <?php endif ; ?>

</div>


            
        
        
            </div>
        <div class="container my-5">
            <div class="row justify-content-center">
                
            </div>
        </div>
        <div class="py-5 bg-image-full" style="background-image: url('https://source.unsplash.com/4ulffa6qoKA/1200x800')">
            <div style="height: 20rem"></div>
        </div>
        <section class="py-5">
            <div class="container my-5">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <h2>Engaging Background Images</h2>
                        <p class="lead">The background images used in this template are sourced from Unsplash and are open source and free to use.</p>
                        <p class="mb-0">I can't tell you how many people say they were turned off from science because of a science teacher that completely sucked out all the inspiration and enthusiasm they had for the course.</p>
                    </div>
                </div>
            </div>
        </section>


<?php 
require_once 'inc/footer.inc.php';       
