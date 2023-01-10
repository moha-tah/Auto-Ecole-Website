<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
	<meta charset="UTF-8">
	<title>Consultation des thèmes</title>
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
            <a href="consultation_theme.php" class="active theme"><li>Thèmes</li></a>
              <a href="ajout_theme.html" class="soustheme"><li>Ajouter</li></a>
              <a href="suppression_theme.php" class="soustheme"><li>Supprimer</li></a>
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

				require('data_bdd.php');

				// on récupère le nombre de thèmes dans notre BDD.
				$requeteNbThemes = "SELECT COUNT(idtheme) FROM themes";
        $resultatNbThemes = mysqli_query($connect, $requeteNbThemes);
				$nbThemes = mysqli_fetch_row($resultatNbThemes);
				$nbThemes = $nbThemes[0];

				echo "<h1>Liste des ".$nbThemes." thèmes</h1>";

				// on récupère le nombre de thèmes valables dans notre BDD.
				$requeteNbThemesValables = "SELECT COUNT(idtheme) FROM themes WHERE supprime = 0";;
				$resultatNbThemesValables = mysqli_query($connect, $requeteNbThemesValables);
				$nbThemesValables = mysqli_fetch_row($resultatNbThemesValables);
				$nbThemesValables = $nbThemesValables[0];

				// s'il n'y en a aucun.
				if ($nbThemesValables == 0) {
						echo "<h2 style='font-weight: bold; color: blue;'>• Il n'y a aucun thème valable.</h2><br><br>";

				// sinon.
        } else {
						echo "<h2 style='font-weight: bold; color: blue;'>
						• Les ".$nbThemesValables." thèmes valables :
						</h2>";

						// (LEFT(s : str, n: int) récupère les n premiers caractères d'une chaîne de caractères s.)
						// on récupère le nom et les 50 premiers caractères de descriptif des thèmes valables.
						$requeteNomsDescriptionsValables = "SELECT nom, LEFT(descriptif, 50) FROM themes WHERE supprime = 0";

		        $listeNomsDescriptionsValables = mysqli_query($connect, $requeteNomsDescriptionsValables);

						// on affiche tous les thèmes valables.
						while ($nomDescriptionValable = mysqli_fetch_array($listeNomsDescriptionsValables, MYSQLI_NUM)) {
								$nom = $nomDescriptionValable[0];
								$descriptif = $nomDescriptionValable[1];

								echo "<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
								echo "• <strong>".$nom."</strong> : ".$descriptif."...";
						}
        };

				// on récupère le nombre de thèmes supprimés dans notre BDD.
				$requeteNbThemesSupprimes = "SELECT COUNT(idtheme) FROM themes WHERE supprime=1";
        $resultatNbThemesSupprimes = mysqli_query($connect, $requeteNbThemesSupprimes);
				$nbThemesSupprimes = mysqli_fetch_row($resultatNbThemesSupprimes);
				$nbThemesSupprimes = $nbThemesSupprimes[0];

				echo "<br><br>";

				// Démarche similaire aux thèmes valables.
				if ($nbThemesSupprimes == 0) {
						echo "<h2 style='font-weight: bold; color: red;'>• Il n'y a aucun thème supprimé.</h2><br><br>";
        } else {

						echo "<h2 style='font-weight: bold; color: red;'>
						• Les ".$nbThemesSupprimes." thèmes supprimés :
						</h2>";

						$requeteNomsDescriptionsSupprimes = "SELECT nom, LEFT(descriptif, 50) FROM themes WHERE supprime = 1";

		        $listeNomsDescriptionsSupprimes = mysqli_query($connect, $requeteNomsDescriptionsSupprimes);

						while ($nomDescriptionSupprime = mysqli_fetch_array($listeNomsDescriptionsSupprimes, MYSQLI_NUM)) {
								$nom = $nomDescriptionSupprime[0];
								$descriptif = $nomDescriptionSupprime[1];

								echo "<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
								echo "• <strong>".$nom."</strong> : ".$descriptif."...";
						}

        };

        echo "<br><br><a href='autoecole.html'>Cliquez ici pour revenir à l'accueil.</a>";

        mysqli_close($connect);

      ?>
    </div>
</div>
</body>
</html>
