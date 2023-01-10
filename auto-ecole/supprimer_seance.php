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

        $idseance = $_POST["choixSeance"];

				// on récupère la date et le thème de la séance maintenant car elle sera supprimée après.
				$requeteSeance = 'SELECT s.dateSeance, t.nom FROM seances AS s INNER JOIN themes AS t
													ON s.idtheme = t.idtheme AND s.idseance='.$idseance;
				$resultatSeance = mysqli_query($connect, $requeteSeance);
				$seance = mysqli_fetch_array($resultatSeance);

				$date = $seance[0];
				$nomTheme = $seance[1];

        // on commence par supprimer toutes les inscriptions à cette séance avant de supprimer la séance.
        $requeteSuppressionInscriptions = "DELETE FROM inscription WHERE idseance=".$idseance;
        $resultatSuppressionInscriptions = mysqli_query($connect, $requeteSuppressionInscriptions);

        $requeteSuppressionSeance = "DELETE FROM seances WHERE idseance=".$idseance;
        $resultatSuppressionSeance = mysqli_query($connect, $requeteSuppressionSeance);

        // si les deux requêtes ont bien fonctionnées.
        if ($resultatSuppressionInscriptions && $resultatSuppressionSeance) {

            echo "<title>Suppression effectuée</title>";
            echo "<h1>Suppression effectuée</h1>";

            echo "<h2>C'est bon !</h2><br>";
            echo "La séance de ".$nomTheme." du ".strftime("%A %d %B %Y", strtotime($date))." a bien été supprimée de la base de données.";
						echo "<br>Les élèves inscrits à cette séance ont été supprimé de la séance.";

            echo '<div style="text-align: center;">
                    <img src="valide.png" width="200px" style="margin-top:30px">
                  </div>';

        } else {
            echo "<title>Échec</title>";
            echo "<h1>Échec</h1>";
            echo "<h2>Suppression de la séance ratée...</h2><br>";
            echo "La suppression a échouée, veuillez réessayer.";

            // image d'une croix rouge symbolisant l'échec.
            echo '<div style="text-align: center;">
                    <img src="invalide.png" width="200px" style="margin-top:30px">
                  </div>';
        }

        echo "<br><br><a href='suppression_seance.php'> Cliquez ici pour retourner sur le formulaire.</a>";

        mysqli_close($connect);
      ?>

    </div>
</div>
</body>
</html>
