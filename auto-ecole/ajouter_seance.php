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
              <a href="ajout_seance.php" class="active soustheme"><li>Créer</li></a>
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

	      $idtheme = $_POST["menuChoixTheme"];
	      $dateSeance = $_POST["dateSeance"];
	      $dateSeanceAffichee = date("d/m/Y", strtotime($dateSeance));
	      $effMax = $_POST["effMax"];

				// on récupère le nom du thème d'idendifiant $idtheme.
	      $requeteNomTheme = "SELECT nom FROM themes WHERE idtheme=".$idtheme;
	      $resultatNomTheme = mysqli_query($connect, $requeteNomTheme);
				// resultatNomTheme renvoie une liste d'un élément, on récupère alors l'unique élement dans $nomTheme.
	      $nomTheme = mysqli_fetch_row($resultatNomTheme)[0];

				// si la séance est dans le passé.
	      if ($date > $dateSeance) {
	      		echo "<title>Insertion ratée</title>";
			      echo "<h1>Insertion ratée</h1>";

						echo "<h2>Insertion de la séance ratée...</h2><br>";
			      echo "Vous ne pouvez pas créer une séance pour une date passée.";

						echo '<div style="text-align: center;">
									<img src="invalide.png" width="200px" style="margin-top:30px">
								</div>';

						echo "<br><br><a href='ajout_seance.php'> Cliquez ici pour retourner sur le formulaire. </a>";

				// si la date est correcte.
	      } else {

						// on cherche à savoir si une séance de $idtheme à la date $dateSeance est déjà programmée.
	  				$requeteSeanceOuNon = 'SELECT idtheme FROM seances WHERE (idtheme='.$idtheme.' AND dateSeance="'.$dateSeance.'")';
						// $seanceOuNon est donc soit vide soit composé d'une ligne.
						$seanceOuNon = mysqli_query($connect, $requeteSeanceOuNon);

						// mysqli_num_rows($seanceOuNon) récupère le nombre de lignes du résultat $seanceOuNon, donc c'est égal à 0 ou 1.
			      if (mysqli_num_rows($seanceOuNon) == 0) {

								// s'il n'y a aucune séance du thème ce jour-là, on enregistre la séance.
				        $requeteInsertion = "INSERT INTO seances values(NULL, '".$dateSeance."', ".$effMax.", ".$idtheme.")";
				        $resultatInsertion = mysqli_query($connect, $requeteInsertion);

								// si la requête a échouée.
				        if (!$resultatInsertion) {

				            echo "<title>Insertion ratée</title>";
				            echo "<h1>Insertion ratée</h1>";

				            echo "<h2>Insertion de la séance ratée...</h2><br>";
				            echo "L'insertion a échouée, veuillez réessayer.";

										echo '<div style="text-align: center;">
					 									<img src="invalide.png" width="200px" style="margin-top:30px">
					 								</div>';

								// sinon.
				        } else {

			         			echo "<title>Insertion réussie</title>";
				            echo "<h1>Insertion réussie</h1>";

										// strftime() permet de formater le jour sous la forme {jour de la semaine} {jour en chiffres} {mois en lettres} {année en chiffres}.
				            echo "<h2>Une séance du thème ".$nomTheme." a bien été ajoutée pour
										le ".strftime("%A %d %B %Y", strtotime($dateSeance)).".</h2>";

										echo '<div style="text-align: center;">
					 									<img src="valide.png" width="200px" style="margin-top:30px">
					 								</div>';

								};

				        echo "<br><br><a href='ajout_seance.php'> Cliquez ici pour retourner sur le formulaire. </a>";

			      } else {

				        echo "<title>Insertion ratée</title>";
				        echo "<h1>Insertion ratée</h1>";
				        echo "<font color=red>Oups... </font>";
				        echo "Vous ne pouvez pas ajouter deux séances du même thème le même jour.";

								echo '<div style="text-align: center;">
											 <img src="invalide.png" width="200px" style="margin-top:30px">
										 </div>';

				        echo "<br><br><a href='ajout_seance.php'> Cliquez ici pour retourner sur le formulaire. </a>";

							};

	        };

				mysqli_close($connect);

			?>

    </div>
</div>
</body>
</html>
