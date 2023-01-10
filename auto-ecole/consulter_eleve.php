<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
	<meta charset="UTF-8">
	<title>Fiche de l'élève</title>
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

      	// tableau : nom, prénom, âge, inscrit depuis, moyenne des notes précédentes, prochaine séance (si elle existe)

        $ideleve = $_POST["choixEleve"];

        echo "<h1>Fiche informative</h1><br><br>";

        $requeteEleve = 'SELECT prenom, nom, dateNaiss, dateInscription FROM eleves WHERE ideleve='.$ideleve;
        $resultatEleve = mysqli_query($connect, $requeteEleve);
        $eleve = mysqli_fetch_array($resultatEleve);

				$prenom = $eleve[0];
				$nom = $eleve[1];
				$dateNaiss = $eleve[2];
				$dateInscription = $eleve[3];


				// date("Y-m-d") : date actuelle.
        $ageEleve = date_diff(date_create($dateNaiss), date_create(date("Y-m-d")));

        echo "<strong>• L'élève s'appelle <font color='blue'>".$prenom." ".$nom."</font>.<br><br>";

        echo "<strong>• Il est né le <font color='blue'>".strftime("%d %B %Y", strtotime($dateNaiss))."
						 ".($ageEleve->format('(%y ans)'))."</font>.<br><br>";

        $ageInscription = date_diff(date_create($dateInscription), date_create(date("Y-m-d")));

        echo "<strong>• Il est inscrit depuis le <font color='blue'>".strftime("%d %B %Y", strtotime($dateInscription))." ".($ageInscription->format('(%y ans, %m mois et %d jours)'))."</font>.<br><br>";

        $requeteMoyenne = "SELECT ROUND(AVG(note), 2) AS moy FROM inscription WHERE note <> -1 AND ideleve=".$ideleve;
        $resultatMoyenneNotes = mysqli_query($connect, $requeteMoyenne);
        $moyenneNotes = mysqli_fetch_array($resultatMoyenneNotes);

        if (!is_null($moyenneNotes['moy'])) {
          	$moy = $moyenneNotes['moy'];
          	echo "<strong>• Son nombre de fautes moyen jusque maintenant est de <font color='blue'>".$moy."</font>.<br><br>";
        } else {
          	echo "<strong>• Aucune de ses précédentes séances n'a encore été notée.</strong><br><br>";
        }

        $requeteDateSeances = "SELECT dateSeance AS date FROM seances AS s INNER JOIN inscription AS i
									ON s.dateSeance >= CURDATE() AND s.idseance = i.idseance AND i.ideleve=".$ideleve." ORDER BY s.dateSeance";
        $dateSeances = mysqli_query($connect, $requeteDateSeances);

        if (mysqli_num_rows($dateSeances) <> 0) {
          	$dateSeance = mysqli_fetch_array($dateSeances);
          	echo "<strong>• Sa prochaine séance de code se déroulera le <font color='blue'>".strftime("%A %d %B %Y", strtotime($dateSeance[0]))."</font>.</strong><br><br>";
        } else {
          	echo "<strong>• Il n'a pas de séance de code à venir.</strong><br><br><br>";
        }

				// on propose à l'utilsateur de choisir un autre élève directement sur la page.
				echo '<form action="consulter_eleve.php" method="POST">';

				// requête pour avoir l'ensemble des ID, noms, prénoms des élèves inscrits.
        $requeteEleves = 'SELECT ideleve, nom, prenom FROM eleves';
        $listeEleves = mysqli_query($connect, $requeteEleves);

        echo '<label for="choixEleve" style="color:green"> Voulez-vous consulter la fiche d\'un autre élève ? </label> <br><br>
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

        echo "<br><br><a href='consultation_eleve.php'>Cliquez ici pour revenir sur le formulaire.</a>";

        mysqli_close($connect);

      ?>
    </div>
</div>
</body>
</html>
