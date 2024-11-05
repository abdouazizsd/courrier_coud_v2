<?php
// Démarre une nouvelle session ou reprend une session existante
session_start();
if (empty($_SESSION['username']) && empty($_SESSION['password'])) {
    header('Location: /courrier_coud/');
    exit();
}
//connexion à la base de données
require('../../../traitement/fonction.php');
// Sélectionnez les options à partir de la base de données avec une pagination
require('../../../traitement/requete.php');
require('../../../traitement/traitOneDepart.php');
$departement = isset($_GET['departement']) ? $_GET['departement'] : '';
$courr = getCourriersByRole();
$idT = $_GET['idT'];
$courriers = recupererTacheParId($idT);
 
    // Utilisez l'id_imputation pour récupérer et afficher les informations nécessaires
    //echo "ID d'imputation: " . htmlspecialchars($id_imputation);

    // Vous pouvez maintenant utiliser $id_imputation pour faire des requêtes supplémentaires,
    // par exemple pour récupérer des informations supplémentaires sur le courrier ou pour ajouter des tâches
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    // Récupérer les valeurs du formulaire
    $statut = $_POST['statut'];
    $date_suivi = $_POST['datetime'];
    // Mettre à jour le courrier
    if (mettreAJourTache($idT, $date_suivi, $statut)) {
        $role = $_SESSION['subrole']; // Supposons que le rôle de l'utilisateur est stocké dans la session
        $redirectUrl = '';
    
        // Déterminer l'URL de redirection en fonction du rôle
        switch ($role) {
            case 'AC':
                $redirectUrl = '/courrier_coud/profils/departement/pageDepCell/ac.php';
                break;
            case 'DI':
                $redirectUrl = '/courrier_coud/profils/departement/pageDepCell/di.php';
                break;
            case 'CELL_PASS_MAR':
                $redirectUrl = '/courrier_coud/profils/departement/pageDepCell/cpm.php';
                break;
            case 'A_I':
                $redirectUrl = '/courrier_coud/profils/departement/pageDepCell/ai.php';
                break;
            case 'A_P':
                $redirectUrl = '/courrier_coud/profils/departement/pageDepCell/ap.php';
                break;
            case 'C_C_I':
                $redirectUrl = '/courrier_coud/profils/departement/pageDepCell/cci.php';
                break;
            case 'C_COOP':
                $redirectUrl = '/courrier_coud/profils/departement/pageDepCell/ccoop.php';
                break;
            case 'C_COM':
                $redirectUrl = '/courrier_coud/profils/departement/pageDepCell/ccom.php';
                break;
            case 'CELL_JURI':
                $redirectUrl = '/courrier_coud/profils/departement/pageDepCell/cj.php';
                break;
            case 'CELL_S_C_Q':
                $redirectUrl = '/courrier_coud/profils/departement/pageDepCell/cscq.php';
                break;
            case 'U_S':
                $redirectUrl = '/courrier_coud/profils/departement/pageDepCell/us.php';
                break;
            case 'B_C':
                $redirectUrl = '/courrier_coud/profils/departement/pageDepCell/bc.php';
                break;
            case 'BAD':
                $redirectUrl = '/courrier_coud/profils/departement/pageDepCell/bad.php';
                break;
            case 'BAP':
                $redirectUrl = '/courrier_coud/profils/departement/pageDepCell/bap.php';
                break;
            case 'DB':
                $redirectUrl = '/courrier_coud/profils/departement/pageDepCell/db.php';
                break;
            case 'DST':
                $redirectUrl = '/courrier_coud/profils/departement/pageDepCell/dst.php';
                break;
            case 'DE':
                $redirectUrl = '/courrier_coud/profils/departement/pageDepCell/de.php';
                break;
            case 'DACS':
                $redirectUrl = '/courrier_coud/profils/departement/pageDepCell/dacs.php';
                break;
            case 'DCU':
                $redirectUrl = '/courrier_coud/profils/departement/pageDepCell/dcu.php';
                break;
            case 'DRU':
                $redirectUrl = '/courrier_coud/profils/departement/pageDepCell/dru.php';
                break;
            case 'DSAS':
                $redirectUrl = '/courrier_coud/profils/departement/pageDepCell/dsas.php';
                break;
            case 'DMG':
                $redirectUrl = '/courrier_coud/profils/departement/pageDepCell/dmg.php';
                break;
            case 'DCH':
                $redirectUrl = '/courrier_coud/profils/departement/pageDepCell/dch.php';
                break;
            case 'CSA':
                $redirectUrl = '/courrier_coud/profils/departement/pageDepCell/csa.php';
                break;
            case 'CONSEILLER':
                $redirectUrl = '/courrier_coud/profils/departement/pageDepCell/conseiller.php';
                break;
            default:
                $redirectUrl = 'defaultPage.php';
                break;
        }
    
        // Afficher le message de succès avec SweetAlert et rediriger
        echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Mise à jour réussie',
                    text: 'La tâche a été mise à jour avec succès.',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '$redirectUrl';
                    }
                });
              </script>";
    } else {
        // Afficher le message d'erreur avec SweetAlert
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    text: 'Erreur lors de la mise à jour.',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.history.back(); // Retourner à la page précédente
                    }
                });
              </script>";
    }
    
    }


?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COUD: GESTION_PANNES</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="log.gif" type="image/x-icon">
    <link rel="icon" href="log.gif" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/base.css" />
    <!-- <link rel="stylesheet" href="../../../assets/css/vendor.css" /> -->
    <link rel="stylesheet" href="../../../assets/css/main.css" />
    <link rel="stylesheet" href="../../../assets/css/datatables.min.css"/>
    <!-- <link rel="stylesheet" href="../../../assets/css/login.css" /> -->
    <link rel="stylesheet" href="../../../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../assets/css/styles.css">
    <link rel="stylesheet" href="../../../assets/css/tableau.css">
    <link rel="stylesheet" href="../../../assets/bootstrap/js/bootstrap.min.js">
    <link rel="stylesheet" href="../../../assets/bootstrap/js/bootstrap.bundle.min.js">
     <!-- Lien vers le CSS de Bootstrap -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Lien vers les icônes Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Lien vers les icônes Fontawesome -->
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        
</head>

<body>
    <?php include('../../../head.php');?>
    <div class="container col-sm-6" style="background-color: #b0cdee">
        <div class="row">
            <div class="card-header" style="background-color: #0056B3;">
                <h1 class="text-white">MISE A JOUR TACHE</h1>
            </div>
        </div>
    </div>
    <div class="container col-8 shadow-lg" style="background-color: #0056B3">
        <div class="row">
            <div class="col-12">
                <div class="datatable">
                    <div class="card ml-4 d-flex justify-content-center">
                        <div class="card-body">
                            <div class="search-container">
                                <form action="" id="myForm2" method="POST" >
                                        <input type="hidden" name="id_imputation" value="<?= htmlspecialchars($courriers['date_suivi'] ?? ''); ?>" required>
                                        <input type="hidden" name="instruction" value="<?= htmlspecialchars($courriers['Statut'] ?? ''); ?>" required>
                                    <div class="mb-4">
                                        <label for="statut" class="form-label" style="color: #0056B3;">Statut</label>
                                        <input style="height: 50px; border-radius: 30px; font-size: 20px;" type="text" name="statut"  value="<?= htmlspecialchars($courriers['Statut'] ?? ''); ?>" class="form-control form-control-lg" placeholder="Entrez le statut" required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="datetime" style="color: #0056B3;">Date et Heure :</label>
                                        <input style="height: 50px; border-radius: 30px; font-size: 20px;" type="datetime-local" name="datetime" id="date" class="form-control" value="<?= htmlspecialchars($courriers['date_suivi'] ?? ''); ?>" required>
                                    </div>
                                    <button type="submit" name="add" class="btn btn-primary mt-4" style="font-size: 10px; border-radius: 30px; background-color: #0056B3 ">Mettre à jour</button>
                                    <a class="btn btn-primary mt-4" href="javascript:history.back()" style="font-size: 10px; border-radius: 30px; background-color: #b0cdee; color: #0056B3">
                                        <i class="fa fa-undo" aria-hidden="true"></i>&nbsp; RETOUR
                                    </a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
    </div>
    <script>
    document.getElementById('myForm2').addEventListener('submit', function(event) {
        var dateInput = document.getElementById('date').value;
        var selectedDate = new Date(dateInput);
        var today = new Date();
        
        // On vérifie que la date sélectionnée n'est pas dans le futur
        if (selectedDate > today) {
            Swal.fire({
                icon: 'error',
                title: 'Erreur de date',
                text: 'La date ne peut pas être dans le futur.',
                confirmButtonText: 'OK'
            });
            event.preventDefault();  // Empêche la soumission du formulaire
        }
    });
</script>
    

<script src="../../assets/js/search_update.js"></script>                   
    <script src="../../assets/js/jquery-3.2.1.min.js"></script>
    <script src="../../assets/js/plugins.js"></script>
    <script src="../../assets/js/main.js"></script>
<script src="../../assets/js/script.js"></script>

</body>

</html>