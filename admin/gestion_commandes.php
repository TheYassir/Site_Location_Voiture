<?php 
require_once '../inc/init.inc.php';
require_once '../admin.inc/nav.admin.inc.php';
$all = $bdd->query("SELECT * FROM commande");
$allin = $all->fetchAll(PDO::FETCH_ASSOC);



?>




<div class="container mx-auto">
<br><br><br>

    <h1 class="display-4 fst-italic text-center my-5">Toutes les commandes</h1>

    <table class="mx-auto table table-hover table-striped text-center align-middle">
            <thead>
                <tr class="table-warning">
                    <?php foreach($allin[0] as $key => $value): ?>
                            <th><?php $date = str_replace('_', ' d\'', $key); echo strtoupper($date) ; ?><?= strtoupper($key); ?></th>
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
                    <td><a href="?action=modification&id_agence=#ici" class="btn btn-warning"><i class="bi bi-pencil-square"></i></a></td>
                    <td><a href="?action=suppression&id_agence=" class="btn btn-danger"><i class="bi bi-trash-fill"></i></a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
    </table>
</div>

    <?php require_once '../inc/footer.inc.php'; 
