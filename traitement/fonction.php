<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- SweetAlert CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<!-- SweetAlert JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    
</body>
</html>

<?php

// Connectez-vous à votre base de données MySQL
function connexionBD()
{
    $connexion = mysqli_connect("localhost", "root", "", "db_courrier");
    // Vérifiez la connexion
    if ($connexion === false) {
        die("Erreur : Impossible de se connecter. " . mysqli_connect_error());
    }
    return $connexion;
}
$connexion = connexionBD();

// Fonction de connexion dans l'espace utilisateur
function login($username, $password)
{
    global $connexion;
    $users = "SELECT * FROM `user` where `Username`='$username' and `Password`='$password'";
    $info = $connexion->query($users);
    return $info->fetch_assoc();
}


function recupererTousLesCourriers($search = '', $page = 1, $itemsPerPage = 10) {
    global $connexion;

    $offset = ($page - 1) * $itemsPerPage;

    // Requête SQL pour récupérer tous les courriers, qu'ils soient imputés ou non
    $sql = "SELECT c.id_courrier, c.date, c.Numero_courrier, c.Objet, c.pdf, c.Nature, c.Type, c.Expediteur,
            i.id_imputation, i.Instruction
            FROM courrier c
            LEFT JOIN imputation i ON c.id_courrier = i.id_courrier";

    // Ajouter une condition de recherche si applicable
    $params = [];
    if (!empty($search)) {
        $sql .= " WHERE c.Numero_Courrier LIKE ? 
                  OR i.Instruction LIKE ? 
                  OR c.Objet LIKE ? 
                  OR c.Nature LIKE ?
                  OR c.Type LIKE ?
                  OR c.Expediteur LIKE ?";
        $likeSearch = "%$search%";
        $params = [$likeSearch, $likeSearch, $likeSearch, $likeSearch, $likeSearch, $likeSearch];
    }

    // Ajouter la clause GROUP BY
    $sql .= " GROUP  BY c.Numero_Courrier";
    // Ajouter la clause ORDER BY pour trier par date et heure dans l'ordre décroissant
    $sql .= " ORDER BY c.date DESC";

    // Ajouter la clause LIMIT pour la pagination
    $sql .= " LIMIT ?, ?";
    $params[] = $offset;
    $params[] = $itemsPerPage;

    // Préparation de la requête
    $stmt = mysqli_prepare($connexion, $sql);
    if ($params) {
        $types = str_repeat('s', count($params) - 2) . 'ii'; // 's' pour string, 'i' pour integer
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (!$result) {
        throw new mysqli_sql_exception("Erreur lors de l'exécution de la requête : " . mysqli_error($connexion));
    }

    $courriers = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $courriers[] = $row;
    }

    return $courriers;
}


function getTotalCourriers($search = '') {
    global $connexion;

    // Requête SQL pour compter le nombre total de courriers
    $sql = "SELECT COUNT(DISTINCT c.Numero_Courrier) as total
            FROM courrier c
            LEFT JOIN imputation i ON c.id_courrier = i.id_courrier";

    // Ajouter une condition de recherche si applicable
    $params = [];
    if (!empty($search)) {
        $sql .= " WHERE c.Numero_Courrier LIKE ? 
                  OR i.Instruction LIKE ? 
                  OR c.Objet LIKE ? 
                  OR c.Nature LIKE ?
                  OR c.Type LIKE ?
                  OR c.Expediteur LIKE ?";
        $likeSearch = "%$search%";
        $params = [$likeSearch, $likeSearch, $likeSearch, $likeSearch,  $likeSearch , $likeSearch	];
    }

    // Préparation de la requête
    $stmt = mysqli_prepare($connexion, $sql);
    if ($params) {
        $types = str_repeat('s', count($params)); // 's' pour string
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (!$result) {
        throw new mysqli_sql_exception("Erreur lors de l'exécution de la requête : " . mysqli_error($connexion));
    }

    $row = mysqli_fetch_assoc($result);

    return $row['total'];
}


    function mettreAJourCourrier($id, $numero,  $date, $objet, $nature, $type, $expediteur) {
        global $connexion; // Utilisation de la connexion globale
        
        $query = "UPDATE courrier SET Numero_Courrier = ?,Date = ? , Objet = ? , Nature = ?, Type = ?, Expediteur = ? WHERE id_courrier = $id";
        $stmt = mysqli_prepare($connexion, $query);
        mysqli_stmt_bind_param($stmt, 'ssssss',$date, $numero,  $objet, $nature, $type, $expediteur);

        if (mysqli_stmt_execute($stmt)) {

        
            echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Mise à jour réussie',
                text: 'Le courrier a été mis à jour avec succès.',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '/courrier_coud/profils/courrier/liste_courrier.php';
                }
            });
        </script>";
    } else {
    // Afficher le message d'erreur avec SweetAlert
    echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Erreur',
                text: 'Erreur lors de la mise à jour du courrier.',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.history.back(); // Retourner à la page précédente
                }
            });
        </script>";
    }
        
    }
 
    function mettreAJourTache($id, $date_suivi, $statut, $pdf = null) {
        global $connexion;
        if ($pdf) {
            // Requête SQL pour mettre à jour la tâche avec le PDF
            $query = "UPDATE suivi SET date_suivi = ?, statut = ?, pdf = ? WHERE id_suivi = ?";
            $stmt = $connexion->prepare($query);
            $stmt->bind_param("sssi", $date_suivi, $statut, $pdf, $id);
        } else {
            // Requête SQL sans le PDF
            $query = "UPDATE suivi SET date_suivi = ?, statut = ? WHERE id_suivi = ?";
            $stmt = $connexion->prepare($query);
            $stmt->bind_param("ssi", $date_suivi, $statut, $id);
        }
    
        $stmt->execute();
        $stmt->close();
    }
    


function getEnumValues($tableName, $columnName) {
    global $connexion;

    // Échapper les noms de table et de colonne pour éviter les injections SQL
    $tableName = $connexion->real_escape_string($tableName);
    $columnName = $connexion->real_escape_string($columnName);

    // Préparer la requête
    $query = "SHOW COLUMNS FROM `$tableName` LIKE '$columnName'";
    $result = $connexion->query($query);

    // Vérifier si la requête a réussi et si des résultats ont été trouvés
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        preg_match('/enum\((.*)\)$/', $row['Type'], $matches);
        
        // Vérifier si nous avons trouvé des valeurs d'énumération
        if (isset($matches[1])) {
            // Extraire et retourner les valeurs d'énumération
            return array_map('trim', str_getcsv($matches[1], ',', "'"));
        }
    }

    // Retourner un tableau vide si aucune valeur n'a été trouvée
    return [];
}



     function recupererImputs($search = '', $page = 1, $itemsPerPage = 10) {
        global $connexion; // Assurez-vous que la connexion à la base de données est disponible
        
        $offset = ($page - 1) * $itemsPerPage;
    
        // Préparation de la requête SQL avec une jointure entre les tables imputation et courrier
        $query = "SELECT i.*, c.Numero_Courrier, c.Objet, c.Nature, c.Type, c.Expediteur, c.Date, c.pdf 
                  FROM imputation i
                  JOIN courrier c ON i.id_courrier = c.id_courrier";
    
        // Si une recherche est spécifiée, on ajoute une clause WHERE
        if (!empty($search)) {
            $search = mysqli_real_escape_string($connexion, trim($search)); // Échappement et trim pour éviter les espaces inutiles
            $query .= " WHERE c.Numero_Courrier LIKE '%$search%' 
                        OR i.instruction LIKE '%$search%' 
                        OR c.Objet LIKE '%$search%' 
                        OR c.Nature LIKE '%$search%'
                        OR c.Type LIKE '%$search%'
                        OR c.Expediteur LIKE '%$search%'";
        }
    
        // Ajouter la clause LIMIT pour la pagination
        $query .= " LIMIT $offset, $itemsPerPage";
    
        // Exécution de la requête
        $result = mysqli_query($connexion, $query);
    
        if (!$result) {
            throw new mysqli_sql_exception("Erreur lors de l'exécution de la requête : " . mysqli_error($connexion));
        }
    
        // Récupération des résultats
        $imputs = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $imputs[] = $row;
        }
    
        return $imputs;
    }
    
    function totalCourrierImputer($search = '') {
        global $connexion;
    
        // Requête SQL pour compter le nombre total de courriers imputés
        $query = "SELECT COUNT(DISTINCT c.id_courrier) AS total
                  FROM courrier c
                  INNER JOIN imputation i ON c.id_courrier = i.id_courrier
                  WHERE i.departement = ?";
    
        $params = [$_SESSION['subrole']];
        if (!empty($search)) {
            $query .= " AND (c.Numero_Courrier LIKE ? 
                            OR i.Instruction LIKE ? 
                            OR c.Objet LIKE ? 
                            OR c.Nature LIKE ?
                            OR c.Type LIKE ?
                            OR c.Expediteur LIKE ?)";
            $likeSearch = "%$search%";
            $params = array_merge($params, [$likeSearch, $likeSearch, $likeSearch, $likeSearch, $likeSearch]);
        }
    
        // Préparer et exécuter la requête
        $stmt = mysqli_prepare($connexion, $query);
        $types = str_repeat('s', count($params));
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
    
        return $row['total'];
    }
    
    
function recupererNumCourriers() {
    global $connexion; // Assurez-vous que la connexion à la base de données est disponible
    $stmt = $connexion->prepare("SELECT Numero_Courrier FROM courrier");
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}


function recupererCourrierParId($id)
{
    global $connexion;
    $sql = "SELECT * FROM courrier WHERE id_courrier = ?";
    $stmt = $connexion->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}
function recupererTacheParId($idT)
{
    global $connexion;
    $sql = "SELECT * FROM suivi WHERE id_suivi = ?";
    $stmt = $connexion->prepare($sql);
    $stmt->bind_param("i", $idT);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}
// SUPPRESSION COURRIER SI IL A DEJA ETE IMPUTER

if (isset($_GET['ids'])) {
    global $connexion;
    $ids = $_GET['ids'];

    // Vérifier si le courrier a déjà été imputé
    $checkQuery = "SELECT COUNT(*) AS total FROM imputation WHERE id_courrier = ?";
    $stmt = $connexion->prepare($checkQuery);
    $stmt->bind_param("i", $ids);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row['total'] > 0) {
        // Si le courrier est imputé, afficher un message et rediriger
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Suppression impossible',
                    text: 'Ce courrier ne peut pas être supprimé car il a déjà été imputé.',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '../profils/courrier/liste_courrier.php';
                    }
                });
              </script>";
    } else {
        // Sinon, procéder à la suppression
        $sql1 = "DELETE FROM courrier WHERE id_courrier = ?";
        $stmt = $connexion->prepare($sql1);
        $stmt->bind_param("i", $ids);
        $stmt->execute();

        // Rediriger après suppression réussie
        header('Location: ../profils/courrier/liste_courrier.php');
    }
    
}


function  modifierImputationParIdImpu($id_imputation) {
    global $connexion; // Utilisation de la connexion globale à la base de données

    // Préparation de la requête de mise à jour
    $query = "UPDATE imputation 
              SET Instruction = ?, departement = ?
              WHERE id_imputation = ?";
    
    // Exécution de la requête avec les valeurs passées en paramètres
    $stmt = $connexion->prepare($query);
    $result = $stmt->execute([ $id_imputation]);

    // Vérification de l'exécution et retour d'une confirmation
    if ($result) {
        return "Imputation mise à jour avec succès.";
    } else {
        return "Erreur lors de la mise à jour de l'imputation.";
    }
}

function recupererImputationsAvecCourriers() {
    global $connexion; // Assurez-vous que la connexion à la base de données est disponible

    $sql = "SELECT i.id_imputation, c.Numero_Courrier, i.Instruction, i.departement
            FROM imputation i
            JOIN courrier c ON i.id_courrier = c.id_courrier";

    $result = mysqli_query($connexion, $sql);
    
    $imputations = [];
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $imputations[] = $row;
        }
    }
    return $imputations;
}

/*function recupererTousLesCourriers() {
    global $connexion;
   

    // Vérifie la connexion
    if ($connexion->connect_error) {
        die("La connexion a échoué : " . $connexion->connect_error);
    }

    // Récupère tous les courriers
    $sql = "SELECT DISTINCT c.id_courrier, c.Numero_Courrier, c.Date, c.Objet, c.Nature, c.pdf, i.id_imputation 
          FROM courrier c 
          LEFT JOIN imputation i ON c.id_courrier = i.id_courrier
          GROUP BY c.Numero_Courrier
           ORDER BY c.Date DESC
           ";
    $result = $connexion->query($sql);

    $courriers = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $courriers[] = $row;
        }
    } else {
        echo "Aucun courrier trouvé.";
    }

    
    return $courriers;
}*/

/**function mettreAJourCourrier($id, $numero, $date, $objet, $nature, $pdfPath = null) {
    global $connexion;

    // Construire la requête de mise à jour
    $sql = "UPDATE courrier SET numero = ?, date = ?, objet = ?, nature = ?";

    // Ajoutez le fichier PDF si un nouveau fichier a été téléchargé
    if ($pdfPath !== null) {
        $sql .= ", pdf = ?";
    }

    $sql .= " WHERE id = ?";

    // Préparez et liez les paramètres
    $stmt = $connexion->prepare($sql);

    if ($pdfPath !== null) {
        $stmt->bind_param("sssssi", $numero, $date, $objet, $nature, $pdfPath, $id);
    } else {
        $stmt->bind_param("ssssi", $numero, $date, $objet, $nature, $id);
    }

    // Exécuter la requête
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }

}*/


/*function recupererImputs() {
    global $connexion; // Assurez-vous que la connexion à la base de données est disponible
    $stmt = $connexion->prepare("SELECT * FROM imputation");
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
 }*/

/*function getEnumValues( $tableName, $columnName) {
    global $connexion;
    $query = "SHOW COLUMNS FROM $tableName LIKE '$columnName'";
    $result = $connexion->query($query);
    $row = $result->fetch_assoc();
    preg_match('/enum\((.*)\)$/', $row['Type'], $matches);
    $enum = str_getcsv($matches[1], ',', "'");
    return $enum;
}*/

/*function recupererTousLesCourriers($search = '', $page = 1, $itemsPerPage = 10) {
    global $connexion;

    $offset = ($page - 1) * $itemsPerPage;

    // Requête SQL pour récupérer tous les courriers, qu'ils soient imputés ou non
    $sql = "SELECT c.id_courrier, c.date, c.Numero_courrier, c.Objet, c.pdf, c.Nature,
            i.id_imputation, i.Instruction
            FROM courrier c
            LEFT JOIN imputation i ON c.id_courrier = i.id_courrier
            ";

    // Ajouter une condition de recherche si applicable
    $params = [];
    if (!empty($search)) {
        $sql .= " WHERE c.Numero_Courrier LIKE ? 
                  OR i.Instruction LIKE ? 
                  OR c.Objet LIKE ? 
                  OR c.Nature LIKE ?";
        $likeSearch = "%$search%";
        $params = [$likeSearch, $likeSearch, $likeSearch, $likeSearch];
    }
    $sql .= " GROUP BY c.id_courrier";
    // Ajouter la clause GROUP BY
    $sql .= " ORDER BY c.date DESC";
    // Ajouter la clause LIMIT pour la pagination
    $sql .= " LIMIT ?, ?";
    $params[] = $offset;
    $params[] = $itemsPerPage;

    // Préparation de la requête
    $stmt = mysqli_prepare($connexion, $sql);
    if ($params) {
        $types = str_repeat('s', count($params) - 2) . 'ii'; // 's' pour string, 'i' pour integer
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (!$result) {
        throw new mysqli_sql_exception("Erreur lors de l'exécution de la requête : " . mysqli_error($connexion));
    }

    $courriers = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $courriers[] = $row;
    }

    return $courriers;
}*/





