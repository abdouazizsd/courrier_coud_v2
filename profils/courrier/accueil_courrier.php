<?php
// Démarre une nouvelle session ou reprend une session existante
session_start();
if (empty($_SESSION['username']) && empty($_SESSION['password'])) {
    header('Location: /courier_coud/');
    exit();
}
// Supprimer une variable de session spécifique
unset($_SESSION['classe']);
// Sélectionnez les options à partir de la base de données avec une pagination
include('../../traitement/fonction.php');
include('../../traitement/fonctionCour.php');
include('../../activite.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COUD: GESTION_COURRIER</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="log.gif" type="image/x-icon">
    <link rel="icon" href="log.gif" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/base.css" />
    <!-- <link rel="stylesheet" href="../../assets/css/vendor.css" /> -->
    <link rel="stylesheet" href="../../assets/css/main.css" />
    <!-- <link rel="stylesheet" href="../../assets/css/datatables.min.css"/> -->
    <!-- <link rel="stylesheet" href="../../assets/css/login.css" /> -->
    <!-- <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="../../assets/css/styles.css">
    <!-- <link rel="stylesheet" href="../../assets/css/tableau.css"> -->
    <link rel="stylesheet" href="../../assets/bootstrap/js/bootstrap.min.js">
    <link rel="stylesheet" href="../../assets/bootstrap/js/bootstrap.bundle.min.js">
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
    <?php include('../../head1.php'); ?>
    <div class="container col-sm-6" style="background-color: #b0cdee">
        <div class="row">
            <div class="card-header" style="background-color: #0056B3;">
                <h1 class="text-white">VEUILLEZ RENSEIGNER LES CHAMPS</h1>
            </div>
        </div>
    </div>
    <div class="container shadow-lg col-md-6" style="background-color: #0056B3;">
        <div class="row">
            <div class="col-12">
                <div class="data-table">
                    <div class="card ml-4 d-flex justify-content-center">
                        <div class="card-body">
                            <div class="search-container ">
                                <form class="col-height" method="POST" id="myForm"
                                      action="../../traitement/fonctionCour.php"  enctype="multipart/form-data" >
                                    
                    
                                    <div class="mb-4">
                                        <label class="form-label" for=""></label>
                                         <input type="text" name="numero" required class="form-control"style="font-size:20px; border-radius: 30px; height: 50px;"
                                                placeholder="Le numero du courrier">
                                    </div>
                     
                                    <div class="mb-4">
                                        <label class="form-label" for="datetime">Date et Heure :</label>
                                        <input type="datetime-local" name="datetime" id="date" class="form-control" style="font-size:20px; border-radius: 30px; height: 50px;"  required>
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label" for=""></label>
                                        <input type="text" name="objet" required class="form-control"style="font-size:20px; border-radius: 30px; height: 50px;"
                                               placeholder="Objet du courrier">
                                    </div>
                                    <div class="mb-4">
                                        <label  class="form-label" for=""></label>
                                        <input type="file" name="pdf" id="pdf" accept=".pdf" required class="form-control border-radius" style="font-size:20px; border-radius: 30px; height: 50px;"
                                               placeholder="Le courrier en format pdf">
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label" for=""></label>
                                        <select name="nature" required class="form-control border-radius" style="font-size: 17px; height: 60px; border-radius: 30px; height: 50px;">
                                            <option value="">Veuillez sélectionner la nature du courrier</option>
                                            <option value="arrive">Arrivé</option>
                                            <option value="depart">Départ</option>
                                        </select>
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label" for=""></label>
                                        <select name="Type" required class="form-control border-radius" style="font-size: 17px; height: 60px; border-radius: 30px; height: 50px;">
                                            <option value="">Veuillez sélectionner le type du courrier</option>
                                            <option value="interne">Interne</option>
                                            <option value="externe">Externe</option>
                                        </select>
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label" for=""></label>
                                         <input type="text" name="expediteur" required class="form-control"style="font-size:20px; border-radius: 30px; height: 50px;"
                                                placeholder="Veillez saisir le nom de l'expediteur">
                                    </div>
            
                                    <div class="card-header">
                                        <button type="submit" class="btn btn-primary" style="background-color: #0056B3; border-radius: 30px;">ENREGISTRER LE COURRIER</button>
                                    </div>
                                </form>

                                <!-- <div class="container shadow-lg" style="border-radius: 30px; text-align: center; background-color: #b0cdee ;">
                                    <a class="btn-primary" style="background-color: #0056B3;"  href="javascript:history.back()">RETOUR</a>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
             
    <!-- Optional JavaScript -->
    <script>
        document.getElementById('myForm').addEventListener('submit', function(event) {
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

</body>
<script src="../../assets/js/script.js"></script>

</html>