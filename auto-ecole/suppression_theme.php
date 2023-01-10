<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
	<meta charset="UTF-8">
	<title>Suppression d'un thème</title>
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

				echo "<h1>Suppression d'un thème</h1>";

	      echo '<h2>Quel thème voulez-vous supprimer ?</h2>';

				// on récupère les thèmes triés par ordre alphabétique de nom.
				$requeteThemesValides = 'SELECT * FROM themes WHERE supprime=0 ORDER BY nom';
	      $listeThemesValides = mysqli_query($connect, $requeteThemesValides);

	      echo '<form method="POST" action="supprimer_theme.php">';
	      echo '<br>
							<label for="menuChoixTheme"> Thème : </label>
							<select name="menuChoixTheme" required>';
	      echo '<option value="" selected disabled hidden> - choisissez un thème - </option>';

	      while ($theme = mysqli_fetch_array($listeThemesValides, MYSQLI_NUM)) {
						$idtheme = $theme[0];
						$descriptif = $theme[1];
	        	echo '<option value="'.$idtheme.'">'.$descriptif.'</option>';
	      };

	      echo '</select>';
	      echo "<br><br>";

	      mysqli_close($connect);

      ?>

      <input type='submit' value='Enregistrer le choix'>
      <br><br>
      <input type='reset' value='Réinitialiser'>

      </form>

    </div>
</div>
</body>
</html>
