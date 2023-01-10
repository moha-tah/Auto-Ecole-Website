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
              <a href="inscription_eleve.php" class="active soustheme"><li>Inscrire un élève</li></a>
              <a href="desinscription_seance.php" class="soustheme"><li>Désinscrire</li></a>
              <a href="suppression_seance.php" class="soustheme"><li>Supprimer</li></a>
        </ul>
    </div>

    <!-- Page de droite -->
    <div class="pageDroite">

      <?php

					require('data_bdd.php');

          $ideleve = $_POST["choixEleve"];
          $idseance = $_POST["choixSeance"];

					// on cherche à savoir si l'élève est déjà inscrit à cette séance.
          $requeteInscritOuNon = 'SELECT * FROM inscription WHERE (idseance='.$idseance.' AND ideleve='.$ideleve.')';
          $inscritOuNon = mysqli_query($connect, $requeteInscritOuNon);

					// s'il n'est pas inscrit, on l'inscrit dans la base de données.
          if (mysqli_num_rows($inscritOuNon) === 0) {

            $requeteInscription = 'INSERT INTO inscription VALUES('.$idseance.', '.$ideleve.', -1)';
            $inscription = mysqli_query($connect, $requeteInscription);


            if (!$inscription) {
            		echo "<title>Inscription ratée</title>";
                echo "<h1>Inscription ratée</h1>";

                echo "<h2>Inscription à la séance ratée...</h2><br>";
                echo "L'insertion a échouée, veuillez réessayer.";

								echo '<div style="text-align: center;">
			                <img src="invalide.png" width="200px" style="margin-top:30px">
			              </div>';

                echo "<br><br><a href='inscription_eleve.php'> Cliquez ici pour retourner sur le formulaire. </a>";

            } else {

                $requeteNomPrenom = 'SELECT prenom, nom FROM eleves where ideleve='.$ideleve;
                $resultatNomPrenom = mysqli_query($connect, $requeteNomPrenom);
                $nomPrenom = mysqli_fetch_array($resultatNomPrenom);

								$prenom = $nomPrenom[0];
								$nom = $nomPrenom[1];

                $requeteNomDateSeance = 'SELECT t.nom, s.dateSeance FROM themes AS t INNER JOIN seances AS s ON s.idseance='.$idseance.' AND t.idtheme = s.idtheme';
                $resultatNomDateSeance = mysqli_query($connect, $requeteNomDateSeance);
                $nomDateSeance = mysqli_fetch_array($resultatNomDateSeance);

								$nomTheme = $nomDateSeance[0];
								$date = $nomDateSeance[1];


                echo "<title>Inscription réussie</title>";
                echo "<h1>Inscription réussie</h1>";
                echo "<h2>C'est bon !</h2><br>";

                echo "L'élève ".$prenom." ".$nom." est inscrit à
                la séance de ".$nomTheme." du ".strftime("%A %d %B %Y", strtotime($date)).".";

								echo '<div style="text-align: center;">
			                <img src="valide.png" width="200px" style="margin-top:30px">
			              </div>';

                echo "<br><br><a href='inscription_eleve.php'> Cliquez ici pour retourner sur le formulaire. </a>";
            };

				// si l'élève est déjà inscrit, on prévient l'utilisateur.
        } else {
						$requeteNomPrenom = 'SELECT prenom, nom FROM eleves where ideleve='.$ideleve;
						$resultatNomPrenom = mysqli_query($connect, $requeteNomPrenom);
						$nomPrenom = mysqli_fetch_array($resultatNomPrenom);

						$requeteNomDateSeance = 'SELECT t.nom, s.dateSeance FROM themes AS t INNER JOIN seances AS s ON s.idseance='.$idseance.' AND t.idtheme = s.idtheme';
						$resultatNomDateSeance = mysqli_query($connect, $requeteNomDateSeance);
						$nomDateSeance = mysqli_fetch_array($resultatNomDateSeance);

		        echo "<title>Inscription ratée</title>";
		        echo "<h1>Inscription ratée</h1>";
		        echo "La Requête est invalide car l'élève ".$prenom." ".$nom." est déjà inscrit
		         à la séance de ".$nomTheme." du ".strftime("%A %d %B %Y", strtotime($date)).".";

						 echo '<div style="text-align: center;">
		               <img src="invalide.png" width="200px" style="margin-top:30px">
		             </div>';

		        echo "<br><br><a href='inscription_eleve.php'> Cliquez ici pour retourner sur le formulaire. </a>";

        };

        mysqli_close($connect);

       ?>

    </div>
</div>
</body>
</html>
