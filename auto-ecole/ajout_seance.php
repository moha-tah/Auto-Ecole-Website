<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
	<meta charset="UTF-8">
	<title>Création d'une séance</title>
	<link rel="stylesheet" href="file.css">
</head>
<body>

<div class="site">
    <!-- Barre latérale, à inclure dans tous les fichiers -->
    <div class="barreGauche">
        <ul>
          <a href="autoecole.html" class="active"><li><h2>Auto-École</h2></li></a>

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

			// data_bdd.php est le fichier contenant des informations générales
			// require permet d'exécuter le code uniquement si le fichier est accessible en lecture.
			require("data_bdd.php");

			// le \ devant l'apostrophe sert à ne pas la considérer comme une fin de chaîne de caractères.
			echo '<h1>Création d\'une séance</h1>';

      echo '<h2>Insertion de la nouvelle séance :</h2>';

			// on récupère tous les thèmes toujours valables en les triant par nom en ordre alphabétique.
      $listeThemes = mysqli_query($connect, 'SELECT idtheme, nom FROM themes WHERE supprime=0 ORDER BY nom');
      echo '<form method="POST" action="ajouter_seance.php">';

      echo '<br><label for="menuChoixTheme">Thème : </label>
						<select name="menuChoixTheme" id="menuChoixTheme" required>';

			// on crée une option non-sélectionnable pour la page initiale.
      echo '<option value="" selected disabled hidden> - choisissez un thème - </option>';

			// on crée toutes les options possibles depuis $listeThemes.
      while ($theme = mysqli_fetch_array($listeThemes, MYSQLI_NUM))
      {	// theme[0] : identifiant unique du thème, theme[1] :  nom du thème
        echo '<option value="'.$theme[0].'">'.$theme[1].'</option>';
      };

      echo '</select>';
			// <br> est une balise pour effectuer un retour à la ligne.
      echo "<br><br>";

			//on coupe la connexion à la base de données.
      mysqli_close($connect);

      ?>

      <label for="dateSeance">Date : </label>
			<input type='date' id='dateSeance' name='dateSeance' required> <br><br>

			<label for="effMax">Effectif maximal : <label for="prenom">
			<input type='number' id='effMax' name='effMax' required> <br><br>

      <input type='submit' value='Enregistrer la séance'> <br><br>

      <input type='reset' value='Réinitialiser'>

      </form>
    </div>

</div>
</body>
</html>
