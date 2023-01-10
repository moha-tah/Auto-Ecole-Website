<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
	<meta charset="UTF-8">
	<title>Calendrier élève</title>
	<link rel="stylesheet" href="file.css">
</head>
<body>

<div class="site">
    <!-- Barre latérale, à inclure dans tous les fichiers -->
    <div class="barreGauche">
        <ul>
          <a href="autoecole.html" class="active"><li><h2>Auto-École</h2></li></a>
            <a href="consultation_eleve.php" class="sousactive theme"><li>Élèves</li></a>
              <a href="ajout_eleve.html" class="soustheme"><li>Inscrire</li></a>
              <a href="visualisation_calendrier_eleve.php" class="active soustheme"><li>Calendrier</li></a>
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

        $ideleve = $_POST["choixEleve"];

				// on récupère le nom et le prénom de l'élève.
        $requeteEleve = 'SELECT prenom, nom FROM eleves WHERE ideleve='.$ideleve;

        $resultatEleve = mysqli_query($connect, $requeteEleve);
        $eleve = mysqli_fetch_array($resultatEleve);

				// $eleve[0] : prénom, $eleve[0] : nom.
				echo "<h1>Calendrier de ".$eleve[0]." ".$eleve[1]." :</h1><br>";

				// on récupère le nombre de séances passées où l'élève concerné a participé.
				$requeteNbSeances = "SELECT COUNT(s.idseance) FROM seances AS s INNER JOIN inscription AS i
															ON s.dateSeance < CURDATE() AND s.idseance = i.idseance AND i.ideleve=".$ideleve;
        $resultatNbSeances = mysqli_query($connect, $requeteNbSeances);
				$nbSeances = mysqli_fetch_row($resultatNbSeances);
				$nbSeances = $nbSeances[0];

				// s'il en a déjà effectué, on prévient l'utilisateur du nombre de séances effectuées et on souligne en bleu.
				if ($nbSeances <> 0) {
        		echo "<strong style='text-decoration: underline blue;'>• Cet élève a déjà effectué ".$nbSeances." séance(s) de code dans le passé.</strong><br><br>";
				// s'il n'a jamais effectué de séances de code, on prévient l'utilisateur et on souligne en rouge.
				} else {
          	echo "<strong style='text-decoration: underline red;'>• Cet élève n'a pas encore effectué des séances de code.</strong><br><br>";
        }

				// on récupère le nombre de séances futures dans lequel l'élève est inscrit.
				$requeteNbSeances = "SELECT COUNT(s.idseance) FROM seances AS s INNER JOIN inscription AS i
															ON s.dateSeance >= CURDATE() AND s.idseance = i.idseance AND i.ideleve=".$ideleve;
        $resultatNbSeances = mysqli_query($connect, $requeteNbSeances);
				$nbSeances = mysqli_fetch_row($resultatNbSeances);
				$nbSeances = $nbSeances[0];

				// s'il est inscrit à aucune séance dans le futur, on prévient l'utilisateur et on souligne en rouge.
				if ($nbSeances == 0) {
						echo "<strong style='text-decoration: underline red;'>• Cet élève n'est inscrit à aucune séance de code dans le futur.</strong><br><br>";
				// s'il est inscrit à des séances, on affiche les détails des séances en question.
				} else {
						echo "<strong style='text-decoration: underline blue;'>• Cet élève a ".$nbSeances." séance(s) de code à venir :</strong><br>";

						$requeteSeances = "SELECT s.dateSeance, t.nom FROM (seances AS s INNER JOIN inscription AS i
						 					ON s.dateSeance >= CURDATE() AND s.idseance = i.idseance AND i.ideleve=".$ideleve.")
											INNER JOIN themes AS t ON s.idtheme = t.idtheme
											ORDER BY s.dateSeance";

		        $listeSeances = mysqli_query($connect, $requeteSeances);

						while ($seance = mysqli_fetch_array($listeSeances, MYSQLI_NUM)) {
								$date = $seance[0];
								$nomTheme = $seance[1];

								// &nbsp permet d'ajouter un espace car si nous mettons un espace normal, le langage HTML les supprime et colle les élements.
								// on met 4 fois &nbsp pour avoir une indentation.
								echo "<br>&nbsp&nbsp&nbsp&nbsp";
								echo '- '.$nomTheme.strftime(" le %A %d %B %Y.", strtotime($date));
						}
        };

				// on propose à l'utilsateur de consulter le calendrier d'un autre élève.
				echo '<br><form action="visualiser_calendrier_eleve.php" method="POST">';

				// requête pour avoir l'ensemble des ID, noms, prénoms des élèves inscrits.
        $requeteEleves = 'SELECT ideleve, nom, prenom FROM eleves';
        $listeEleves = mysqli_query($connect, $requeteEleves);

        echo '<label for="choixEleve" style="color:green"> Voulez-vous consulter le calendrier d\'un autre élève ? </label> <br><br>
							<select name="choixEleve" id="choixEleve" required>';
        echo '<option value="" selected disabled hidden> - choisissez un élève - </option>';

				// on affiche les élèves.
        while ($eleve = mysqli_fetch_array($listeEleves, MYSQLI_NUM)) {
						$ideleve = $eleve[0];
						$nom = $eleve[1];
						$prenom = $eleve[2];

          	echo '<option value="'.$ideleve.'">'.$prenom." ".$nom.'</option>';
        };
				// on oublie pas de fermer notre balise pour sélectionner l'élève.
        echo '</select>';

				echo '<br><br>';

        echo '<input value="Valider" type="submit">';

        echo "<br><br><a href='visualisation_calendrier_eleve.php'>Cliquez ici pour revenir sur le formulaire.</a>";

        mysqli_close($connect);

      ?>
    </div>
</div>
</body>
</html>
