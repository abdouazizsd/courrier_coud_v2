<?php
// Démarre une nouvelle session ou reprend une session existante
session_start();
if (empty($_SESSION['username']) && empty($_SESSION['password'])) {
    header('Location: /courrier_coud/');
    exit();
}
//connexion à la base de données
require('../../traitement/fonction.php');
require('../../traitement/recupImpuAlldep.php');
// Sélectionnez les options à partir de la base de données avec une pagination
require('../../traitement/requete.php');


$courriers = recupererTousLesCourriers();

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COUD: GESTION_COURRIER</title>
    <link rel="shortcut icon" href="log.gif" type="image/x-icon">
    <link rel="icon" href="log.gif" type="image/x-icon">
    <!-- <link rel="stylesheet" href="../../assets/css/vendor.css" /> -->
    <link rel="stylesheet" href="../../assets/css/main.css" />
    <link rel="stylesheet" href="../../assets/css/styles.css">
    <link rel="stylesheet" href="../../assets/css/tableau.css">
    <link rel="stylesheet" href="../../assets/css/datatables.min.css">
    <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
    <!-- Lien vers le CSS de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Lien vers les icônes Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Lien vers les icônes Fontawesome -->
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <?php include('../../head.php');?>
    <div class="container col-sm-6" style="background-color: #b0cdee">
        <div class="row">
            <div class="card-header" style="background-color: #0056B3;">
                <h1 class="text-white">SUIVRE L'EVOLUTION DES COURRIERS</h1>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end" style="margin-right: 300px">
        <div class="btn-group">
            <button class="btn btn-primary" style="font-size: 20px; background-color: #0056B3;" onclick="javascript:history.back()">
                <i class="fa fa-repeat" style="font-size: 20px; " aria-hidden="true"></i>&nbsp;Retour
            </button>
        </div>
    </div>
    <div class="container SHA" style="background-color: #0056B3;">
            <div class="row">
                <div class="col-12">
                    <div class="data_table">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Numero_corrier</th>
                                    <th>Département</th>
                                    <th>Instruction</th>
                                    <th>Évolution</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($suiv_par_departement as $departement => $suivis): ?>
                                    <?php foreach ($suivis as $suivi): ?>
                                        <tr style="font-size: 15px;">
                                            <td class="text-center pt-4" style="text-align: center;"><?= htmlspecialchars($suivi['Numero_Courrier']); ?></td>
                                            <td class="text-center pt-4" style="text-align: center;"><?= htmlspecialchars($departement); ?></td>
                                            <td class="text-center pt-4" style="text-align: center;">
                                             <?php 
                                                    // Affiche l'instruction personnalisée si elle est disponible, sinon l'instruction générale
                                                    echo htmlspecialchars(!empty($suivi['instruction_personnalisee']) ? $suivi['instruction_personnalisee'] : $suivi['Instruction']);
                                             ?>

                                            </td>
                                            <td class="text-center pt-4" style="text-align: center;">
                                                <a class="btn btn-primary" href="detailTaches.php?id_imputation=<?= htmlspecialchars($suivi['id_imputation']); ?>">Évolution</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <script src="../../assets/js/jquery-3.2.1.min.js"></script>
    <script src="../../assets/js/plugins.js"></script>
    <script src="../../assets/js/main.js"></script>
</body>
<script src="../../assets/js/script.js"></script>

</html>
