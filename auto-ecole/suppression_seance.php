<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
	<meta charset="UTF-8">
	<title>Supprimer une séance</title>
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
            <a href="consultation_theme.php" class="theme"><li>Thèmes</li></a>
              <a href="ajout_theme.html" class="soustheme"><li>Ajouter</li></a>
              <a href="suppression_theme.php" class="soustheme"><li>Supprimer</li></a>
            <a href="consultation_seance.php" class="sousactive theme"><li>Séances</li></a>
              <a href="ajout_seance.php" class="soustheme"><li>Créer</li></a>
              <a href="validation_seance.php" class="soustheme"><li>Noter</li></a>
              <a href="inscription_eleve.php" class="soustheme"><li>Inscrire un élève</li></a>
              <a href="desinscription_seance.php" class="soustheme"><li>Désinscrire</li></a>
              <a href="suppression_seance.php" class="active soustheme"><li>Supprimer</li></a>
        </ul>
    </div>

    <!-- Page de droite -->
		<div class="pageDroite">

	    <?php

	        require("data_bdd.php");

					echo "<h1>Suppression d'une séance</h1>";

	        echo '<h2>Quelle séance future voulez-vous supprimer ?</h2><br>';

					// on récupère toutes les séances dans le futur.
	        $requeteSeancesFutures = 'SELECT s.idseance, s.dateSeance, t.nom FROM seances AS s INNER JOIN themes AS t
                	                  ON s.dateSeance>=CURDATE() AND s.idtheme = t.idtheme
                										ORDER BY s.dateSeance';
	        $listeSeancesFutures = mysqli_query($connect, $requeteSeancesFutures);

	        echo '<form method="POST" action="supprimer_seance.php">';

	        echo 'Séance : <select style="text-align:center;" name="choixSeance" required>';
	        echo '<option value="" selected disabled hidden> - choisissez une séance - </option>';

					// on ajoute chaque séance en option du select.
	        while ($seance = mysqli_fetch_array($listeSeancesFutures, MYSQLI_NUM)) {
						$idseance = $seance[0];
						$date = $seance[1];
						$nomTheme = $seance[2];
	            echo '<option value="'.$idseance.'">'.$nomTheme.' - '.strftime("%A %d %B %Y", strtotime($date)).'</option>';
	        };

	        echo '</select>';
	        echo "<br>";

	        mysqli_close($connect);
	    ?>

	    <br><br>
	    <input type='submit' value='Enregistrer le choix'>
	    <br><br>
	    <input type='reset' value='Réinitialiser'>

	    </form>

		</div>

</div>
</body>

</html>
