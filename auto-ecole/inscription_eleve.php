<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
	<meta charset="UTF-8">
	<title>Inscription élève/séance</title>
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
              <a href="inscription_eleve.php" class="active soustheme"><li>Inscrire un élève</li></a>
              <a href="desinscription_seance.php" class="soustheme"><li>Désinscrire</li></a>
              <a href="suppression_seance.php" class="soustheme"><li>Supprimer</li></a>
        </ul>
    </div>

    <!-- Page de droite -->
    <div class="pageDroite">
      <?php

				require('data_bdd.php');

				echo '<h1>Inscription élève/séance</h1>';

        echo '<form action="inscrire_eleve.php" method="POST">';

				// on récupère tous les id, noms et prénoms des élèves.
        $requeteEleves = 'SELECT ideleve, nom, prenom, dateNaiss FROM eleves ORDER BY prenom, nom';
        $listeEleves = mysqli_query($connect, $requeteEleves);

        echo '<h2>Élève à inscrire :</h2> <select name="choixEleve" required>';
        echo '<option value="" selected disabled hidden> - choisissez un élève - </option>';

				// on ajoute les élèves dans notre <select>.
				while ($eleve = mysqli_fetch_array($listeEleves, MYSQLI_NUM)) {
						$ideleve = $eleve[0];
						$nom = $eleve[1];
						$prenom = $eleve[2];
						$dateNaiss = $eleve[3];

						// la fonction doublons est définie dans data_bdd.php.
						$strDateNaiss = doublons($connect, $nom, $prenom, $dateNaiss);
	          echo '<option value="'.$ideleve.'">'.$prenom.' '.$nom.$strDateNaiss.'</option>';
        };

        echo '</select>';
        echo '<br><br>';

				// on récupère la liste des séances dans le futur et qui ne sont pas déjà pleines.
        $requeteSeances = 'SELECT s.idseance, s.dateSeance, t.nom FROM seances AS s INNER JOIN themes AS t
							              ON s.idtheme = t.idtheme
							              AND s.dateSeance >= CURDATE()
														AND (SELECT COUNT(ideleve) FROM inscription AS i WHERE s.idseance = i.idseance) < s.effMax
							              ORDER BY s.dateSeance';
        $listeSeances = mysqli_query($connect, $requeteSeances);

        echo '<label for="choixSeance"> <h2>Séance :</h2> </label>
							<select name="choixSeance" id="choixSeance" required>';
        echo '<option value="" selected disabled hidden> - choisissez une séance - </option>';

        while ($seance = mysqli_fetch_array($listeSeances, MYSQLI_NUM)) {
						$idseance = $seance[0];
						$dateSeance = $seance[1];
						$nomTheme = $seance[2];

          	echo '<option value="'.$idseance.'">'.$nomTheme.' - '.date("d/m/Y", strtotime($dateSeance)).'</option>';
        };

        echo '</select>';
        echo '<br><br>';

				echo '<input value="Valider" type="submit">&nbsp&nbsp';
        echo '<input value="Effacer" type="reset">';

        mysqli_close($connect);

        ?>
    </div>
</div>
</body>
</html>
