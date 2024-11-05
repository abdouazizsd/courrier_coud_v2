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
include('../../traitement/requete.php');
//$courriers = recupererTousLesCourriers();


$search = isset($_GET['search']) ? $_GET['search'] : '';
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$itemsPerPage = 10;

$courriers = recupererTousLesCourriers($search, $page, $itemsPerPage);
$totalCourriers = getTotalCourriers($search);
$totalPages = ceil($totalCourriers / $itemsPerPage);

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
    <link rel="stylesheet" href="../../assets/css/main.css">
    <link rel="stylesheet" href="../../assets/css/datatables.min.css">
    <link rel="stylesheet" href="../../assets/css/styles.css">
    <link rel="stylesheet" href="../../assets/css/tableau.css">
    <!-- Lien vers le CSS de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Lien vers les icônes Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Lien vers les icônes Fontawesome -->
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
</head>

<body>
    <?php include('../../head1.php'); ?>
    <div class="container col-sm-6" style="background-color: #b0cdee">
        <div class="row">
            <div class="card-header" style="background-color: #0056B3;">
                <h1 class="text-white">LISTE DES COURRIERS</h1>
            </div>
        </div>
    </div>
        <!-- Formulaire de recherche -->
    <div class="search-container ">
        <form method="GET" action="">
            <div class="box custom-div-rounded">
                <input type="text" class="form-control" name="search" value="<?= htmlspecialchars($search); ?>" placeholder="Rechercher ..." >
            </div>
        </form>
    </div>
    <div class="container shadow-lg" style="background-color: #0056B3;">
        <div class="row">
            <div class="col-12">
                <div class="data_table">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr style="font-size:20px;">
                                <th>Numéro</th>
                                <th>Date</th>
                                <th>Objet</th>
                                <th>Nature</th>
                                <th>Type</th>
                                <th>Expediteur</th>
                                <th>PDF</th>
                                <th>METTRE A JOUR</th>
                                <th>SUPPRIMER</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($courriers as $courrier): ?>
                                <tr style="font-size:20px;">
                                    <td class="text-center pt-4" style="text-align: center;"><?= htmlspecialchars($courrier['Numero_courrier']); ?></td>
                                    <td class="text-center pt-4" style="text-align: center;"><?= htmlspecialchars($courrier['date']); ?></td>
                                    <td class="text-center pt-4" style="text-align: center;"><?= htmlspecialchars($courrier['Objet']); ?></td>
                                    <td class="text-center pt-4" style="text-align: center;"><?= htmlspecialchars($courrier['Nature']); ?></td>
                                    <td class="text-center pt-4" style="text-align: center;"><?= htmlspecialchars($courrier['Type']); ?></td>
                                    <td class="text-center pt-4" style="text-align: center;"><?= htmlspecialchars($courrier['Expediteur']); ?></td>
                                    <td class="text-center pt-4" style="text-align: center;">
                                        <a href="../uploads/<?= htmlspecialchars($courrier['pdf']); ?>"
                                            target="_blank" type="button" class="btn btn-warning">
                                            <i class="bi bi-file-earmark-pdf-fill"></i>
                                        </a>
                                    </td>
                                    <td class="text-center pt-4" style="text-align: center;">
                                    <a href="mise_a_jour.php?id=<?= htmlspecialchars($courrier['id_courrier']); ?>"
                                            class="btn btn-primary">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    </td>
                                    <td class="text-center pt-4" style="text-align: center; ">
                                    <a href="#" class="btn btn-danger delete-btn" data-id="<?= htmlspecialchars($courrier['id_courrier']); ?>">
                                            <i class="bi bi-trash"></i>
                                    </a>    
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        </div>
        <!-- Pagination -->
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= $i == $page ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?= $i; ?>&search=<?= htmlspecialchars($search); ?>"><?= $i; ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
        <div class="d-flex justify-content-center">
            <div class="btn-group">
                <button class="btn btn-primary" style="font-size: 15px;" onclick="javascript:history.back()">
                    <i class="fa fa-repeat" aria-hidden="true"></i>&nbsp;Retour
                </button>
            </div>
        </div>
    </div>
    <!-- Button trigger modal -->
    <script>
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault(); // Empêche le lien de fonctionner immédiatement

            const id = this.getAttribute('data-id'); // Récupère l'ID du courrier

            // Affiche la boîte de dialogue SweetAlert
            Swal.fire({
                title: 'Êtes-vous sûr de vouloir supprimer ce courrier?',
                text: "Cette action est irréversible!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Oui, supprimer!',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirige vers l'URL de suppression si confirmé
                    window.location.href = `../../traitement/fonction.php?ids=${id}`;
                }
            });
        });
    });
</script>

    <!-- Modal -->
    
    
    <script src="../../assets/js/search_update.js"></script>                   
    <script src="../../assets/js/jquery-3.2.1.min.js"></script>
    <script src="../../assets/js/plugins.js"></script>
    <script src="../../assets/js/main.js"></script>
</body>

    <script src="../../assets/js/script.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</html>