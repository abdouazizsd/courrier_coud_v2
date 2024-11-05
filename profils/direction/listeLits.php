<?php
session_start();

// Vérification de la session utilisateur
if (empty($_SESSION['username']) || empty($_SESSION['password'])) {
    header('Location: /courrier_coud/');
    exit();
}
// Inclusion des fichiers nécessaires
include('../../traitement/fonction.php');
connexionBD();
include('../../traitement/requete.php');
// Vérification de l'ID du courrier
if (isset($_SESSION['id_courrier'])) {
    $id_courrier = $_SESSION['id_courrier'];
} else {
    echo "ID COURRIER INDISPONIBLE";
    exit(); // Arrêter l'exécution si l'ID est indisponible
}
// Initialisation des départements
$departments = isset($_SESSION['selected_departments']) ? $_SESSION['selected_departments'] : [];
// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['departements'])) {
    $selectedDepts = $_POST['departements'];
    // Stocker les départements dans la session
    $_SESSION['selected_departments'] = $selectedDepts;
    // Rediriger vers la page finale
    header('Location: displayDepartments.php');
    exit();
}
// Récupération des départements via une fonction
$departements = getEnumValues('departement', 'Nom_dept');
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COUD: GESTION_COURRIERS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="log.gif" type="image/x-icon">
    <link rel="icon" href="log.gif" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/base.css" />
    <link rel="stylesheet" href="../../assets/css/vendor.css" />
    <link rel="stylesheet" href="../../assets/css/main.css" />
    <link rel="stylesheet" href="../../assets/css/login.css" />
    <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css/styles.css">
    <!-- Lien vers le CSS de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Lien vers les icônes Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Lien vers les icônes Fontawesome -->
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .department-button {
            border-radius: 10px; /* Arrondir les coins des boutons */
            margin-bottom: 10px; /* Espacement entre les boutons */
            display: block; /* S'assurer que les labels s'affichent en bloc */
            text-align: center; /* Centrer le texte horizontalement */
            line-height: 4.5rem; /* Ajuster la hauteur de ligne pour centrer verticalement */
        }

        .department-container {
            padding: 20px;
            border-radius: 15px; /* Arrondir les coins du conteneur */
            box-shadow: 0 4px 8px rgba(0, 51, 102, 0.5); /* Ajouter une ombre légère */
            background-color: #fff; /* Couleur de fond douce pour le conteneur */
        }
        .btn-primary{
            background-color: #8287a2;
           
        }
    </style>
</head>

<body>
    <?php include('../../head.php'); ?>
    <div class="container col-sm-6" style="background-color: #b0cdee">
        <div class="row">
            <div class="card-header" style="background-color: #0056B3 ;">
                <h1 class="text-white">SELECTION LES DEPARTEMENTS OU CELLULES</h1>
            </div>
        </div>
    </div>
    <form method="POST" action="listeLits.php">
        <div class="container department-container">
            <div class="row">
                <?php
                $colCount = 0;
                foreach ($departements as $departement) {
                    echo '<div class="col-md-2 col-sm-4 mb-3">'; // Ajuster le nombre de colonnes par ligne
                    echo '<input type="checkbox" name="departements[]" id="dept-' . htmlspecialchars($departement) . '" value="' . htmlspecialchars($departement) . '" class="btn-check">';
                    echo '<label class="btn btn-primary text-white text-center department-button" 
                        style= "margin: 5px; background-color" for="dept-' . htmlspecialchars($departement) . '">' . htmlspecialchars($departement) . '</label>';
                    echo '</div>';
                    $colCount++;
                    // Aucun besoin de réinitialiser $colCount ici, Bootstrap gère les lignes automatiquement
                }
                ?>
            </div>
            <div class="text-center mt-2" style="font-size: 20px">
                <button type="submit" class="text-white" style = "background-color: #0056B3">Valider la Sélection</button>
            </div>
            <div class="container shadow-lg" style="border-radius: 30px; text-align: center; background-color: #8287a2; height: 50px;">
                <a class="text-white" style=" border: none;"  href="javascript:history.back()">
                    <i class="fa fa-repeat" aria-hidden="true"></i>&nbsp; RETOUR
                </a>
            </div>
        </div>
    </form>
    <script src="../../assets/js/jquery-3.2.1.min.js"></script>
    <script src="../../assets/js/plugins.js"></script>
    <script src="../../assets/js/main.js"></script>
    <script src="../../assets/js/script.js"></script>
</body>
</html>
