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

        echo "<title>Notation en cours</title>";
        echo "<h1>Notation en cours</h1>";

				// on récupère la date et le thème de la séance.
        $requeteSeance = 'SELECT s.dateSeance, t.nom FROM seances AS s INNER JOIN themes AS t
                  ON s.idtheme = t.idtheme AND s.idseance='.$idseance;
        $resultatSeance = mysqli_query($connect, $requeteSeance);
        $seance = mysqli_fetch_array($resultatSeance);
				$dateSeance = $seance[0];
				$nomTheme = $seance[1];

        echo "<form action='noter_eleves.php' method='POST'>";
				// seance[0] : date de la séance, seance[1] : nom du thème de la séance.
        echo "<h2>Veuillez insérer le nombre de fautes pour la séance de ".$nomTheme." du ".strftime("%A %d %B %Y", strtotime($date)).".</h2><br><br>";

				// on récupère l'id, le nom, le prénom et la note de chaque élève pour cette séance.
				$requeteElevesInscrits = 'SELECT e.ideleve, e.nom, e.prenom, e.dateNaiss, i.note FROM eleves AS e INNER JOIN inscription AS i
				 													ON e.ideleve=i.ideleve AND i.idseance='.$idseance;
        $listeElevesInscrits = mysqli_query($connect, $requeteElevesInscrits);

        while ($eleve = mysqli_fetch_array($listeElevesInscrits, MYSQLI_NUM)) {
						$ideleve = $eleve[0];
						$nom = $eleve[1];
						$prenom = $eleve[2];
						$dateNaiss = $eleve[3];
						$note = $eleve[4];
						$strDateNaiss = doublons($connect, $nom, $prenom, $dateNaiss);

						// si l'élève n'est pas encore noté, par défaut la case où le texte devra être insérée contiendra un Ø.
	          if ($note == -1) {
	            	$placeholder = "placeholder=Ø";

						// si l'élève a déjà été noté (modification de note), alors la case contiendra son ancienne note.
	          } else {
	            	$placeholder = "placeholder=".$note;
	          };

	          echo "<label for='".$ideleve."'> ".$prenom." ".$nom.$strDateNaiss." : </label>";
	          echo "<input type='number' id='".$ideleve."' name='".$ideleve."' min=0 max=40 ".$placeholder." required><br><br>";

        };

        echo "<input type='hidden' name='choixSeance' value=".$idseance.">";

        echo "<br>
              <input type='submit' value='Enregistrer le choix'>
              <br><br>
              <input type='reset' value='Réinitialiser'>
              </form>";

				echo "<br><a href='validation_seance.php'> Cliquez ici pour retourner sur le formulaire.</a>";

        mysqli_close($connect);
      ?>

    </div>
</div>
</body>
</html>
