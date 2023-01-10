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
          <a href="autoecole.html" class="logo active"><li><h2>Auto-École</h2></li></a>
            <a href="consultation_eleve.php" class="theme"><li>Élèves</li></a>
              <a href="ajout_eleve.html" class="soustheme"><li>Inscrire</li></a>
              <a href="visualisation_calendrier_eleve.php" class="soustheme"><li>Calendrier</li></a>
            <a href="consultation_theme.php" class="sousactive theme"><li>Thèmes</li></a>
              <a href="ajout_theme.html" class="active soustheme"><li>Ajouter</li></a>
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

	      $nom = ucwords(strtolower($_POST["nom"]));
				// ucfirst(str) permet de convertir en majuscule au tout premier terme d'une chaîne de caractères.
	      $descriptif = ucfirst($_POST["descriptif"]);

	      $nom = mysqli_real_escape_string($connect, $nom);
	      $descriptif = mysqli_real_escape_string($connect, $descriptif);

				// on cherche si des thèmes ont déjà ce nom.
	      $requeteThemeExistant = 'SELECT * FROM themes WHERE nom="'.$nom.'"';
	      $resultatThemeExistant = mysqli_query($connect, $requeteThemeExistant);

				// si ce thème n'existe pas, alors notre reqûete sera une insertion dans une nouvelle ligne de la table themes.
	      if (mysqli_num_rows($resultatThemeExistant)==0) {
	        	$requeteInsertion = 'INSERT into themes values(NULL,"'.$nom.'", 0 ,"'.$descriptif.'")';

				// s'il existe déjà, nous nous contenterons de mettre à jour le descriptif et rendre le thème valable.
	      } else {
	        	$requeteInsertion = 'UPDATE themes SET supprime=0 AND descriptif="'.$descriptif.'" WHERE nom="'.$nom.'"';
	      };

	      $resultatInsertion = mysqli_query($connect, $requeteInsertion);

	      if (!$resultatInsertion) {

	      		echo "<title>Insertion ratée</title>";
	          echo "<h1>Insertion ratée</h1>";

	          echo "<h2>Insertion du thème ratée...</h2><br>";
	          echo "L'insertion a échouée, veuillez réessayer.";

	          echo '<div style="text-align: center;">
	                 <img src="invalide.png" width="200px" style="margin-top:30px">
	                </div>';

	      } else {

	          echo "<title>Insertion réussie</title>";
	          echo "<h1>Insertion réussie</h1>";

	          echo "<h2>Nom du thème ajouté : ".$nom.".</h2> <br><br>";

	          echo "La description du thème ".$nom." ajouté est : ".$descriptif.". <br><br>";

	          echo '<div style="text-align: center;">
	                <img src="valide.png" width="200px" style="margin-top:30px">
	              </div>';

	      };

	      echo "<br><br><a href='ajout_theme.html'> Cliquez ici pour retourner sur le formulaire. </a>";

	      mysqli_close($connect);

      ?>

    </div>
</div>
</body>
</html>
