<?php
include('fonction.php');
$error = "";

if (!empty($_GET['username']) && !empty($_GET['password'])) {
    $username = $_GET['username'];
    $password = $_GET['password'];
    $row = login($username, $password);
    if ($row) {
        session_start();
        $_SESSION['id_user'] = $row['id_user'];
        $_SESSION['username'] = $row['Username'];
        $_SESSION['password'] = $row['Password'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['Fonction'] = $row['Fonction'];
        $_SESSION['Prenom'] = $row['Prenom'];
        $_SESSION['Nom'] = $row['Nom'];
        $_SESSION['Matricule'] = $row['Matricule'];
        $_SESSION['Tel'] = $row['Tel'];
        $_SESSION['Actif'] = $row['Atif'];
        $_SESSION['subrole'] = $row['subrole'];
        if ($row['Fonction'] == 'bureau_courrier') {
            header('Location: /courrier_coud/profils/courrier/liste_courrier.php');
            exit();
        } else if ($row['Fonction'] == 'direction') {
            header('Location: /courrier_coud/profils/direction/accueil_direction.php');
            exit();
        } else if ($row['Fonction'] == 'departement') {
            switch ($row['subrole']) {
                case 'AC':
                    header('Location: /courrier_coud/profils/departement/pageDepCell/ac.php');
                    break;
                case 'DI':
                    header("Location: /courrier_coud/profils/departement/pageDepCell/di.php");
                    break;
                
             case 'CELL_PASS_MAR':
                 header("Location: /courrier_coud/profils/departement/pageDepCell/cpm.php");
                 break;
             case 'A_I':
                  header("Location: /courrier_coud/profils/departement/pageDepCell/ai.php");
                 break;
            case 'A_P':
                header("Location: /courrier_coud/profils/departement/pageDepCell/ap.php");
                 break;
            case 'C_C_I':
                 header("Location: /courrier_coud/profils/departement/pageDepCell/cci.php");
                 break;
             case 'C_COOP':
                 header("Location: /courrier_coud/profils/departement/pageDepCell/ccoop.php");
                 break;
             case 'C_COM':
                 header("Location: /courrier_coud/profils/departement/pageDepCell/ccom.php");
                 break;
             case 'CELL_JURI':
                 header("Location: /courrier_coud/profils/departement/pageDepCell/cj.php");
                 break;
             case 'CELL_S_C_Q':
                 header("Location: /courrier_coud/profils/departement/pageDepCell/cscq.php");
                 break;
            
            case 'U_S':
                header("Location: /courrier_coud/profils/departement/pageDepCell/us.php");
                break;
            case 'B_C':
                header("Location: /courrier_coud/profils/departement/pageDepCell/bc.php");
                break;
            case 'BAD':
                 header("Location: /courrier_coud/profils/departement/pageDepCell/bad.php");
                break;
            case 'BAP':
                 header("Location: /courrier_coud/profils/departement/pageDepCell/bap.php");
                 break;
            case 'DB':
                 header("Location: /courrier_coud/profils/departement/pageDepCell/db.php");
                 break;
            case 'DST':
                 header("Location: /courrier_coud/profils/departement/pageDepCell/dst.php");
                 break;
            case 'DE':
                 header("Location: /courrier_coud/profils/departement/pageDepCell/de.php");
                 break;
             case 'DACS':
                 header("Location: /courrier_coud/profils/departement/pageDepCell/dacs.php");
                 break;
             case 'DCU':
                 header("Location: /courrier_coud/profils/departement/pageDepCell/dcu.php");
                 break;
            case 'DRU':
                header("Location: /courrier_coud/profils/departement/pageDepCell/dru.php");
                break;
            case 'DSAS':
                header("Location: /courrier_coud/profils/departement/pageDepCell/dsas.php");
                break;
            case 'DMG':
                header("Location: /courrier_coud/profils/departement/pageDepCell/dmg.php");
                break;
            case 'DCH':
                 header("Location: /courrier_coud/profils/departement/pageDepCell/dch.php");
                break;
            case 'CSA':
                header("Location: /courrier_coud/profils/departement/pageDepCell/csa.php");
                break;
            case 'CONSEILLER':
                 header("Location: /courrier_coud/profils/departement/pageDepCell/conseiller.php");
                break;
                // Ajoutez d'autres cas selon vos départements
                default:
                    header("Location: defaultPage.php");
                    break;
            }
           // header('Location: /courrier_coud/profils/departement/accueil_departement.php');
            exit();
        } 
      
      }
    
    else {
        $error_message = 'Incorrect username or password!';
        $error = "Nom d'utilisateur ou mot de passe Incorrect";
        header('Location: /courrier_coud/?error=' . $error);
        exit();
    }
}
