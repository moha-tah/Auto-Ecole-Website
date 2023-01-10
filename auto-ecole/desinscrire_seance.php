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
              <a href="desinscription_seance.php" class="active soustheme"><li>Désinscrire</li></a>
              <a href="suppression_seance.php" class="soustheme"><li>Supprimer</li></a>
        </ul>
    </div>

    <!-- Page de droite -->
    <div class="pageDroite">

      <?php

				require("data_bdd.php");

        $idseance = $_POST["choixSeance"];

				// on récupère dates et noms de thème de toutes les séances pour les afficher plus tard.
				$requeteDatesNoms = 'SELECT s.dateSeance, t.nom FROM seances AS s INNER JOIN themes AS t
									ON s.idtheme = t.idtheme AND s.idseance='.$idseance;
				$resultatDatesNoms = mysqli_query($connect, $requeteDatesNoms);
				$listeDateNoms = mysqli_fetch_array($resultatDatesNoms);
				$date = $listeDateNoms[0];
				$nomTheme = $listeDateNoms[1];

				// si c'est la première connexion sur cette page, on demande quels élèves doivent être désinscrits.
        if (is_null($_POST["choixEffectue"])) {

						// on récupère la liste des élèves inscrits à la séance sélectionnée dans la page d'avant.
            $requeteEleves = 'SELECT e.ideleve, e.nom, e.prenom, e.dateNaiss FROM eleves AS e INNER JOIN inscription AS i
						 									ON e.ideleve=i.ideleve AND i.idseance='.$idseance.' ORDER BY e.prenom, e.nom';
            $listeEleves = mysqli_query($connect, $requeteEleves);


            echo "<title>Désinscription en cours</title>";
            echo "<h1>Désinscription en cours</h1>";

            echo "<form action='desinscrire_seance.php' method='POST'>";
            echo "<h2>Veuillez choisir les élèves à désinscrire pour la séance de ".$nomTheme." du ".strftime("%A %d %B %Y", strtotime($date)).".</h2>";

            while ($eleve = mysqli_fetch_array($listeEleves, MYSQLI_NUM)) {
								$ideleve = $eleve[0];
								$nom = $eleve[1];
								$prenom = $eleve[2];
								$dateNaiss = $eleve[3];

								$strDateNaiss = doublons($connect, $nom, $prenom, $dateNaiss);

		            echo "<br><br><input type='checkbox' name='choixEleves[]' id=".$ideleve." value=".$ideleve.">";
		            echo "<label for=".$ideleve.">&nbsp&nbsp".$prenom." ".$nom.$strDateNaiss."</label>";
            };

            echo "<br><input type='hidden' name='choixSeance' value=".$idseance.">";

            echo "<br>
                  <input type='submit' name='choixEffectue' value='Enregistrer le choix'>
                  <br><br>
                  <input type='reset' value='Réinitialiser'>
                  </form>";

						echo "<br><br><a href='desinscription_seance.php'> Cliquez ici pour retourner sur le formulaire. </a>";

				// si c'est la deuxième fois qu'on passe sur la page, on désinscrit les élèves recueillis ci-dessus.
				} else {

			    	$choixEleves = $_POST["choixEleves"];

				    foreach ($choixEleves as $ideleve) {
			      		$requeteDesinscription = 'DELETE FROM inscription WHERE idseance='.$idseance.' AND ideleve='.$ideleve;
				      	$desinscription = mysqli_query($connect, $requeteDesinscription);
				    };

				    echo "<title>Désinscription réussie</title>";
				    echo "<h1>Désinscription réussie</h1>";
				    echo "<h2>C'est bon !</h2><br>";

				    echo "Les élèves séléctionnés ont bien été désinscrits de la séance de ".$nomTheme." du ".strftime("%A %d %B %Y", strtotime($date)).".";

				    echo '<div style="text-align: center;">
				          <img src="valide.png" width="200px" style="margin-top:30px">
				        </div>';

				    echo "<meta http-equiv='refresh' content='5; URL=desinscription_seance.php'>";
				    echo "<br><br><a href='desinscription_seance.php'> Cliquez ici pour retourner sur le formulaire. (Automatique au bout de 5 secondes.) </a>";
				};

        mysqli_close($connect);

      ?>

    </div>
</div>
</body>
</html>
