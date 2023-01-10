<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="file.css">
</head>
<body>

<div class="site">
    <!-- Barre latérale, à inclure dans tous les fichiers -->
    <div class="barreGauche">
        <ul>
          <a href="autoecole.html" class="active"><li><h2>Auto-École</h2></li></a>
            <a href="consultation_eleve.php" class="theme"><li>Élèves</li></a>
              <a href="ajout_eleve.html" class="soustheme"><li>Inscrire</li></a>
              <a href="visualisation_calendrier_eleve.php" class="soustheme"><li>Calendrier</li></a>
            <a href="consultation_theme.php" class="sousactive theme"><li>Thèmes</li></a>
              <a href="ajout_theme.html" class="soustheme"><li>Ajouter</li></a>
              <a href="suppression_theme.php" class="active   soustheme"><li>Supprimer</li></a>
            <a href="consultation_seance.php" class="theme"><li>Séances</li></a>
              <a href="ajout_seance.php" class="soustheme"><li>Créer</li></a>
              <a href="validation_seance.php" class="soustheme"><li>Noter</li></a>
              <a href="inscription_eleve.php" class="soustheme"><li>Inscrire un élève</li></a>
              <a href="desinscription_seance.php" class="soustheme"><li>Désinscrire</li></a>
              <a href="suppression_seance.php" class="soustheme"><li>Supprimer</li></a>
        </ul>
    </div>



    <!-- Page de droite -->
    <div class="pageDroite">
      <?php

				require("data_bdd.php");

	      $idtheme = $_POST["menuChoixTheme"];

				// on met à jour la table themes en rendant le thème {idtheme} obsolète.
	      $requeteMaJ = 'UPDATE themes SET supprime=1 where idtheme='.$idtheme;
	      $miseAJour = mysqli_query($connect, $requeteMaJ);

	      if (!$miseAJour) {

						echo "<title>Supression ratée</title>";
						echo "<h1>Supression ratée</h1>";

						echo "<h2>Supression du thème ratée...</h2><br>";
						echo "L'Supression a échouée, veuillez réessayer.";

						echo '<div style="text-align: center;">
	                <img src="invalide.png" width="200px" style="margin-top:30px">
	              </div>';

	      } else {

	      		echo "<title>Supression réussie</title>";
						echo "<h1>Supression réussie</h1>";

	          echo "<h2>C'est bon !</h2>";

						// on récupère le nom du thème associé à {idtheme}.
						$requeteNomTheme = 'SELECT nom FROM themes where idtheme='.$idtheme;
						$resultatTheme = mysqli_query($connect, $requeteNomTheme);
						$theme = mysqli_fetch_array($resultatTheme);
						$theme = $theme[0];

						// on prévient l'utilisateur que les séances passées ne seront pas supprimées.
						echo "<br>Le thème ".$theme." n'est désormais plus disponible,
						les séances dans le passé avec ce thème restent toujours exploitables et consultables.";

						echo '<div style="text-align: center;">
	                <img src="valide.png" width="200px" style="margin-top:30px">
	              </div>';

	      };

	      echo "<br><br><a href='suppression_theme.php'> Cliquez ici pour retourner sur le formulaire. </a>";

	      mysqli_close($connect);

      ?>
    </div>
</div>
</body>
</html>
