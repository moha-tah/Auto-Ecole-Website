<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
	<meta charset="UTF-8">
	<title>Consultation des séances</title>
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
            <a href="consultation_seance.php" class="active theme"><li>Séances</li></a>
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

				echo "<h1>Calendrier général :</h1>";

				// on récupère le nombre de séances dans le passé.
				$requeteNbSeancesPassees = "SELECT COUNT(s.idseance) FROM seances AS s WHERE s.dateSeance < CURDATE()";
        $nbSeancesPassees = mysqli_query($connect, $requeteNbSeancesPassees);

				// on récupère la première (et unique) ligne du résultat.
				$nbSeancesPassees = mysqli_fetch_row($nbSeancesPassees);
				// on récupère le premier (et unique) terme de la première ligne du résultat.
				$nbSeancesPassees = $nbSeancesPassees[0];

				// s'il y a eu des séances dans le passé.
				if ($nbSeancesPassees <> 0) {
          	echo "<h2 style='color:blue'>• Il y a eu ".$nbSeancesPassees." séance(s) de code dans le passé.</h2><br><br>";
				// sinon.
        } else {
          	echo "<h2 style='color:red'>• Il n'y a eu aucune séance de code dans le passé.</h2><br><br>";
        };

				// démarche équivalente pour les séances futures.
				$requeteNbSeancesFutures = "SELECT COUNT(s.idseance) FROM seances AS s WHERE s.dateSeance >= CURDATE()";
        $nbSeancesFutures = mysqli_query($connect, $requeteNbSeancesFutures);
				$nbSeancesFutures = mysqli_fetch_row($nbSeancesFutures);
				$nbSeancesFutures = $nbSeancesFutures[0];

				// s'il y a 0 séance dans le futur.
				if ($nbSeancesFutures == 0) {
						echo "<h2 style='color:purple'>• Il n'y a aucune séance de code dans le futur.</h2><br><br>";

				//sinon, on affiche l'ensemble des séances à venir.
        } else {

						echo "<h2 style='color:green'>• Il y a ".$nbSeancesFutures." séance(s) de code à venir :</h2>";

						// on récupère la date et le thème de chaque séance dans le futur,
						// en triant par date puis par ordre alphabétique de nom de thème.
						$requeteDatesNoms = "SELECT s.dateSeance, t.nom FROM seances AS s INNER JOIN themes AS t
		                  ON s.dateSeance >= CURDATE() AND s.idtheme = t.idtheme
											ORDER BY s.dateSeance, t.nom";

		        $listeDatesNoms = mysqli_query($connect, $requeteDatesNoms);

						// on affiche les séances.
						while ($dateNom = mysqli_fetch_array($listeDatesNoms, MYSQLI_NUM)) {
								$date = $dateNom[0];
								$nomTheme = $dateNom[1];
								echo "<br>&nbsp&nbsp&nbsp&nbsp";
								echo '<strong>- '.$nomTheme.strftime(" le %A %d %B %Y.", strtotime($date)).'</strong>';

						}

        };

        echo "<br><br><a href='autoecole.html'>Cliquez ici pour revenir à l'accueil.</a>";

        mysqli_close($connect);

      ?>

    </div>
</div>
</body>
</html>
