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
							<a href="validation_seance.php" class="active soustheme"><li>Noter</li></a>
              <a href="inscription_eleve.php" class="soustheme"><li>Inscrire un élève</li></a>
              <a href="desinscription_seance.php" class="soustheme"><li>Désinscrire</li></a>
              <a href="suppression_seance.php" class="soustheme"><li>Supprimer</li></a>
        </ul>
    </div>

    <!-- Page de droite -->
    <div class="pageDroite">

      <?php

				require("data_bdd.php");

        $idseance = $_POST["choixSeance"];

        $requeteElevesInscrits = 'SELECT e.ideleve FROM eleves AS e INNER JOIN inscription AS i
				 					ON e.ideleve=i.ideleve AND i.idseance='.$idseance;
        $listeElevesInscrits = mysqli_query($connect, $requeteElevesInscrits);

        while ($ideleve = mysqli_fetch_array($listeElevesInscrits, MYSQLI_NUM)) {
						$ideleve = $ideleve[0];

						//strval(n : int) convertit un entier n en chaîne de caractères.
						// on insère dans la BDD la note de chaque élève en connaissant le $_POST[..] associé car on a nommé chaque input note auparavant par son ideleve.
	          $requeteMaJ_note = 'UPDATE inscription SET note='.$_POST[strval($ideleve)].' WHERE ideleve='.$ideleve.' AND idseance='.$idseance;
	          mysqli_query($connect, $requeteMaJ_note);

        };

        $requeteNomDate = 'SELECT t.nom, s.dateSeance FROM seances AS s INNER JOIN themes AS t
				 									 ON s.idtheme=t.idtheme AND s.idseance='.$idseance;
        $resultatNomDate = mysqli_query($connect, $requeteNomDate);
        $nomDate = mysqli_fetch_array($resultatNomDate);

				$nomTheme = $nomDate[0];
				$date = $nomDate[1];

        echo '<title>Séance notée</title>';
        echo '<h1>Séance notée</h1>';

        echo "<h2><font color='blue'>Tout est bon !</font></h2><br>";

        echo "Toutes les notes pour la séance de ".$nomTheme." du ".strftime("%A %d %B %Y", strtotime($date))." ont bien été insérées dans la base de données.";

				echo '<div style="text-align: center;">
							<img src="valide.png" width="200px" style="margin-top:30px">
						</div>';

        echo "<br><br><a href='validation_seance.php'> Cliquez ici pour retourner sur le formulaire.</a>";

        mysqli_close($connect);

      ?>

    </div>
</div>
</body>
</html>
