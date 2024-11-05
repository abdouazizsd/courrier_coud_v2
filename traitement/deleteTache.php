<?php

require_once('fonction.php');
$connexion = connexionBD() ;


if ( isset($_GET['idsT']) ) {
    
        global $connexion;
    $idsT = $_GET['idsT' ];
    $fun = $_GET['func'];
    $role = $_GET['role'];


    $sql1= "DELETE FROM suivi WHERE id_suivi = $idsT";
    $query = $connexion -> prepare($sql1);
    $query -> execute();
    if ($query->execute()) {
        // Redirection après mise à jour réussie
       
        if ($role == 'departement'){
        switch ($fun) {
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
            header("Location: ");
                
        }
       // header('Location: /courrier_coud/profils/departement/accueil_departement.php');
        exit();
     
    } else {
        echo "Erreur lors de la mise à jour.";
    }
}


}