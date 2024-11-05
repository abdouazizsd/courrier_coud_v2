<?php
if (empty($_SESSION['username']) && empty($_SESSION['password'])) {
  header('Location: /courrier_coud/');
  exit();
}

?>

<head>
  <!--- basic page needs================================================== -->
  <meta charset="utf-8" />
  <title>CAMPUS COUD</title>
  <meta name="description" content="" />
  <meta name="author" content="" />

  <!-- mobile specific metas================================================== -->
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- CSS================================================== -->
  <link rel="stylesheet" href="assets/css/base.css" />
  <!-- <link rel="stylesheet" href="assets/css/vendor.css" /> -->
  <link rel="stylesheet" href="assets/css/main.css" />

  <!-- script================================================== -->
  <script src="../assets/js/modernizr.js"></script>
  <script src="assets/js/pace.min.js"></script>

  <!-- favicons================================================== -->
  <link rel="shortcut icon" href="log.gif" type="image/x-icon" />
  <link rel="icon" href="log.gif" type="image/x-icon" />
</head>

<body id="top">
  <!-- header================================================== -->
  <header class="s-header">
    <div class="header-logo">
      <a class="site-logo" href="#"><img src="/courrier_coud/assets/images/logo.png" alt="Homepage" /></a>
      CENTRE DES OEUVRES UNIVERSITAIRE DE DAKAR
    </div>
    <nav class="header-nav-wrap">
      <ul class="header-nav">
       
        <li class="nav-item">
          <a class="nav-link" href="/courrier_coud/" title="Déconnexion"><i class="fa fa-sign-out" aria-hidden="true"></i> Déconnexion</a>
        </li>
      </ul>
    </nav>

    <a class="header-menu-toggle" href="#0"><span>Menu</span></a>
  </header>
  <!-- end s-header -->
</body>
<section id="homedesigne" class="s-homedesigne">
  <?php if (($_SESSION['Fonction'] == 'departement') 
       || ($_SESSION['Fonction'] == 'bureau_courrier') 
       || ($_SESSION['Fonction'] == 'direction')) { ?>
       
    <p class="lead">Espace Administration: Bienvenue! <br> <br> <span>
        (<?= $_SESSION['Prenom'] . "  " . $_SESSION['Nom'] . " " . $_SESSION['Fonction'] ?>)
      </span></p>
  <?php } elseif ($_SESSION['profil'] == 'user') { ?>
    <p class="lead">Espace etudiant: Bienvenue! <br> <br> <span>
        (<?= $_SESSION['prenom'] . "  " . $_SESSION['nom'] ?>)
      </span><br><br><span><?= $_SESSION['classe']; ?></span></p>
  <?php } ?>
</section>