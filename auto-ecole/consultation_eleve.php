<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
	<meta charset="UTF-8">
	<title>Consultation Fiche Élève</title>
	<link rel="stylesheet" href="file.css">
</head>
<body>

<div class="site">
    <!-- Barre latérale, à inclure dans tous les fichiers -->
    <div class="barreGauche">
        <ul>
          <a href="autoecole.html" class="active"><li><h2>Auto-École</h2></li></a>
            <a href="consultation_eleve.php" class="active theme"><li>Élèves</li></a>
              <a href="ajout_eleve.html" class="soustheme"><li>Inscrire</li></a>
              <a href="visualisation_calendrier_eleve.php" class="soustheme"><li>Calendrier</li></a>
            <a href="consultation_theme.php" class="theme"><li>Thèmes</li></a>
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

				echo "<h1>Consultation Fiche Élève</h1>";

        echo "<h2>Les informations de quel élève voulez-vous afficher ?</h2><br><br>";

        echo '<form action="consulter_eleve.php" method="POST">';

				// requête pour avoir l'ensemble des ID, noms, prénoms des élèves inscrits.
        $requeteEleves = 'SELECT ideleve, nom, prenom, dateNaiss FROM eleves ORDER BY prenom, nom';
        $listeEleves = mysqli_query($connect, $requeteEleves);

        echo '<label for="choixEleve"> Fiche à consulter : </label>
							<select name="choixEleve" id="choixEleve" required>';
        echo '<option value="" selected disabled hidden> - choisissez un élève - </option>';

				// on affiche les élèves.
				while ($eleve = mysqli_fetch_array($listeEleves, MYSQLI_NUM)) {
						$ideleve = $eleve[0];
						$nom = $eleve[1];
						$prenom = $eleve[2];
						$dateNaiss = $eleve[3];

						// la fonction doublons est définie dans data_bdd.php.
						$strDateNaiss = doublons($connect, $nom, $prenom, $dateNaiss);
	          echo '<option value="'.$ideleve.'">'.$prenom.' '.$nom.$strDateNaiss.'</option>';
        };
				// on oublie pas de fermer notre balise pour sélectionner l'élève.
        echo '</select>';

        echo '<br><br>';

        echo '<input value="Valider" type="submit"> ';
        echo '<input value="Effacer" type="reset">';

				mysqli_close($connect);

      ?>

    </div>
</div>
</body>
</html>
