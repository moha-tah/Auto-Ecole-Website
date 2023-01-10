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
            <a href="consultation_eleve.php" class="sousactive theme"><li>Élèves</li></a>
              <a href="ajout_eleve.html" class="active soustheme"><li>Inscrire</li></a>
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

      <?php require('data_bdd.php');

				// strtolower(str) permet de convertir toutes les lettres d'un chaîne de caractères en minuscules.
				// ucwords(str) permet de convertir en majuscule à la première lettre de chaque terme d'un str.

				// J'ai donc décidé d'utiliser ucwords(strtolower(str)) pour mettre les noms dans un formalisme usuel.
        $nom = ucwords(strtolower($_POST["nom"]));
        $prenom = ucwords(strtolower($_POST["prenom"]));

				// mysqli_real_escape_string() remplace les apostrophes d'une chaîne de caractères par des \'
				// ceci permet d'être protégée contre des injections SQL.
        $nom = mysqli_real_escape_string($connect, $nom);
        $prenom = mysqli_real_escape_string($connect, $prenom);

        $datenaiss = $_POST["datenaiss"];
				// datenaissAffichee permet d'afficher la date de naissance en format JJ/MM/YYYY, utilisé en France.
        $datenaissAffichee = date("d/m/Y", strtotime($datenaiss));


				// fonction trouvée sur stackoverflow pour calculer l'âge d'un élève :

				// création de deux objets de la classe DateTime grâce à 'new'.
        $dateActuelle = new DateTime($date);
        $dateDeNaissance = new DateTime($datenaiss);

				// on appelle la méthode diff(DateTime) d'un objet DateTime.
				// elle permet de faire la différence entre notre date et une date donnée en arguments.
        $differenceAbsolue = $dateDeNaissance -> diff($dateActuelle);
        $differenceAnnees = $differenceAbsolue->y;

				// on récupère la liste des élèves s'appelant {$prenom} {$nom}.
        $requete = 'SELECT nom, prenom FROM eleves WHERE (nom="'.$nom.'" AND prenom="'.$prenom.'")';
        $listeEleves = mysqli_query($connect, $requete);

				// s'il n'y a aucun élève nommé {$prenom} {$nom}, on l'insère directement dans la BDD.
        if (mysqli_num_rows($listeEleves) === 0) {
          $requete = 'insert into eleves values(NULL,"'.$nom.'","'.$prenom.'","'.$datenaiss.'","'.$date.'")';
          $resultat = mysqli_query($connect, $requete);

					// si la reqûete ne fonctionne pas.
          if (!$resultat) {
              echo "<title>Échec</title>";
							echo "<h1>Échec</h1>";
              echo "<h2>Insertion de l'élève ratée...</h2><br>";
              echo "L'insertion a échouée, veuillez réessayer.";

							// image d'une croix rouge symbolisant l'échec.
							echo '<div style="text-align: center;">
		 									<img src="invalide.png" width="200px" style="margin-top:30px">
		 								</div>';

					// si la requête fonctionne.
          } else {
								// si l'âge de l'élève est supérieur à 16, on peut l'inscrire.
      				if ($differenceAnnees >= 16) {
	        				echo "<title>Insertion réussie</title>";
									echo "<h1>Insertion réussie</h1>";
			            echo "<h2>Insertion de l'élève réussie !</h2> <br>";

			            echo "C'est bon ! ".$prenom." ".$nom.", né(e) le ".$datenaissAffichee." (".$differenceAnnees." ans),
			                  a bien été inscrit(e) en ce ".strftime("%A %d %B %Y", strtotime($date)).".";

								 	// image d'un cercle vert symbolisant la réussite.
								 	echo '<div style="text-align: center;">
			 										<img src="valide.png" width="200px" style="margin-top:30px">
			 									</div>';

							//sinon, on prévient l'utilisateur que l'élève est trop jeune.
		          } else {
		            echo "<title>Échec</title>";
								echo "<h1>Échec</h1>";
		            echo "<h2>Insertion de l'élève ratée...</h2><br>";

		            echo "L'élève n'a que <font color=red>".$differenceAnnees."</font color> ans. L'âge minimal est de 16 ans.";

								echo '<div style="text-align: center;">
			 									<img src="invalide.png" width="200px" style="margin-top:30px">
			 								</div>';
		          }
          };

          echo "<br><br><a href='ajout_eleve.html'> Cliquez ici pour retourner sur le formulaire.</a>";

	      } else {

			      echo '<title>Précision nécessaire</title>';
						echo '<h1>Précision nécessaire</h1>';
			      echo '<h2>Une précision est nécessaire</h2><br><br>';
						// $nomprenom[0] : nom, $nomprenom[1] : prénom.
			      echo "L'élève ".$prenom." ".$nom." existe déjà. <br> Que voulez-vous faire ?";

			      echo '<form action="valider_eleve.php" method="post">';

			      echo '<br><br><input type="radio" name="choix" id="oubli" value="oubli" checked>
						<label for="oubli"> Annuler l\'ajout </label> <br>';
			      echo '<input type="radio" name="choix" id="ajout" value="ajout">
						<label for="ajout"> Ajouter l\'élève quand même </label> <br><br>';

			      echo '<input value="Valider" type="submit">';

						// on utilise des input hidden pour pouvoir récupérer les données utiles pour le deuxième formulaire.
			      echo '<input type="hidden" name="nom" value="'.$nom.'">';
			      echo '<input type="hidden" name="prenom" value="'.$prenom.'">';
			      echo '<input type="hidden" name="datenaiss" value="'.$datenaiss.'">';

			      echo '</form>';

	      };

        mysqli_close($connect);

       ?>

    </div>
</div>
</body>
</html>
