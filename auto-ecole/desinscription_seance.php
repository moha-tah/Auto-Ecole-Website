<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
	<meta charset="UTF-8">
	<title>Désinscription Séance</title>
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
              <a href="desinscription_seance.php" class="active soustheme"><li>Désinscrire</li></a>
              <a href="suppression_seance.php" class="soustheme"><li>Supprimer</li></a>
        </ul>
    </div>

    <!-- Page de droite -->
    <div class="pageDroite">
			<?php
	        require("data_bdd.php");

					echo "<h1>Choix d'une séance pour désinscription</h1>";

	        echo '<h2>De quelle séance voulez-vous désinscrire des élèves ?</h2><br>';

					// cette requête sélectionne les séances futures dans lequel il y a au moins un participant.
					// (une séance sans élève ne peut pas se voir désinscrire des élèves.)
	        $requeteSeancesFutures = 'SELECT s.idseance, s.dateSeance, t.nom FROM seances as s INNER JOIN themes as t
										                ON (s.idtheme=t.idtheme)
										                AND (SELECT COUNT(ideleve) FROM inscription AS i WHERE s.idseance = i.idseance) > 0
										                AND s.dateSeance >= CURDATE()
										                ORDER BY s.dateSeance';

	        $seancesFutures = mysqli_query($connect, $requeteSeancesFutures);

	        echo '<form method="POST" action="desinscrire_seance.php">';

	        echo '<label for="choixSeance"> Séance : </label>
								<select name="choixSeance" id="choixSeance" required>';
	        echo '<option value="" selected disabled hidden> - choisissez une séance - </option>';


	        while ($seance = mysqli_fetch_array($seancesFutures, MYSQLI_NUM)) {
							$idseance = $seance[0];
							$date = $seance[1];
							$nomTheme = $seance[2];
	            echo '<option value="'.$idseance.'">'.$nomTheme.' - '.strftime("%A %d %B %Y", strtotime($date)).'</option>';
	        };

	        echo '</select>';
	        echo "<br>";

	        mysqli_close($connect);

	    ?>

			<br>
      <input type='submit' value='Enregistrer le choix'>
      <br><br>
      <input type='reset' value='Réinitialiser'>

      </form>

    </div>
</div>
</body>
</html>
