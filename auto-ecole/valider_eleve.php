<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
	<meta charset="UTF-8">
	<title>Ajout d'un élève</title>
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

	      $nom = $_POST["nom"];
	      $prenom = $_POST["prenom"];
	      $datenaiss = $_POST["datenaiss"];
	      $datenaissAffichee = date("d/m/Y", strtotime($datenaiss));
	      $choix = $_POST["choix"];

				// si l'utilisateur décide de ne pas enregistrer un nouvel élève portant le même nom, on ne fait rien.
	      if ($choix == "oubli") {

	        echo "<title>Annulation</title>";
	        echo "<h1>Ajout annulé</h1>";
	        echo "<h2>L'ajout de l'élève ".$prenom." ".$nom." a bien été annulé.</h2>";

					echo '<div style="text-align: center;">
								 <img src="valide.png" width="200px" style="margin-top:30px">
							 </div>';

	      } else { // ($choix == "ajout"), si l'utilisateur veut quand-même enregistrer l'élève, on ajoute la ligne à la BDD.

	        $requeteInsertion = 'INSERT INTO eleves VALUES(NULL, "'.$nom.'", "'.$prenom.'", "'.$datenaiss.'", "'.$date.'")';
	        $resultatInsertion = mysqli_query($connect, $requeteInsertion);

	        if (!$resultatInsertion) {
		          echo "<title>Échec</title>";
		          echo "<h1>Insertion de l'élève ratée...</h1><br>";
		          echo "<h2>L'insertion a échouée, veuillez réessayer.</h2>";

							echo '<div style="text-align: center;">
										 <img src="invalide.png" width="200px" style="margin-top:30px">
									 </div>';

	        } else {

							// création de deux objets de la classe DateTime grâce à 'new'.
							$dateActuelle = new DateTime($date);
							$dateDeNaissance = new DateTime($datenaiss);

							// on appelle la méthode diff(DateTime) d'un objet DateTime.
							// elle permet de faire la différence entre notre date et une date donnée en arguments.
							$differenceAbsolue = $dateDeNaissance -> diff($dateActuelle);
							$differenceAnnees = $differenceAbsolue->y;

							// si l'élève a plus de 16 ans, on l'insère dans la BDD.
			        if ($differenceAnnees >= 16) {
				          echo "<title>Insertion réussie</title>";
				          echo "<h1>Insertion de l'élève réussie !</h1> <br>";

				          echo "<h2>C'est bon ! ".$prenom." ".$nom.", né(e) le ".$datenaissAffichee." (".$differenceAnnees." ans),
				                a bien été inscrit(e) en ce ".strftime("%A %d %B %Y", strtotime($date)).".</h2>";

									echo '<div style="text-align: center;">
												 <img src="valide.png" width="200px" style="margin-top:30px">
											 </div>';

							// sinon on informe l'utilisateur que l'élève est trop jeune.
			        } else {
				          echo "<title>Échec</title>";
				          echo "<h1>Insertion de l'élève ratée...</h1><br>";

				          echo "<h2>L'élève n'a que <font color=red>".$differenceAnnees."</font color> ans. L'âge minimal est de 16 ans.</h2>";

									echo '<div style="text-align: center;">
												 <img src="invalide.png" width="200px" style="margin-top:30px">
											 </div>';
			        }
	        };
	      };

	      echo "<br><br><a href='ajout_eleve.html'> Cliquez ici pour retourner sur le formulaire. </a>";

	      mysqli_close($connect);

      ?>

    </div>
</div>
</body>
</html>
