<!-- Type, choix, nom, requis -->

    <?= radio('Civilité', ['Madame', 'Monsieur'], 'civilite', 'required'); ?>
    <?= input('text', 'Nom', 'nom', 'required', $_SESSION['nom']); ?>
    <?= input('text', 'Nom d\'épouse', 'nom_epouse', isset($_COOKIE['nom_epouse']) ? $_COOKIE['nom_epouse'] : ""); ?>
    <?= input('text', 'Prénom', 'prenom', 'required', $_SESSION['prenom']); ?>
    <?= input('mail', 'Adresse Mail', 'email', 'required', $_SESSION['email']); ?>
    <?= input('date', 'Date de naissance', 'birthDate', 'required', isset($_COOKIE['birthDate']) ? $_COOKIE['birthDate'] : ""); ?>
    <?= input('text', 'Pays de naissance', 'countryBirth', 'required', isset($_COOKIE['countryBirth']) ? $_COOKIE['countryBirth'] : ""); ?>
    <?= input('text', 'Ville de naissance', 'cityBirth', 'required', isset($_COOKIE['cityBirth']) ? $_COOKIE['cityBirth'] : ""); ?>
    <?= input('text', 'Nationalité', 'nationalite', 'required', isset($_COOKIE['nationalite']) ? $_COOKIE['nationalite'] : ""); ?>
    <?= input('text', 'Langue maternelle', 'langueMat', 'required', isset($_COOKIE['langueMat']) ? $_COOKIE['langueMat'] : ""); ?>
    <?php // input('tel', 'Numéro de téléphone', 'numTel', 'required', isset($_COOKIE['numTel']) ? $_COOKIE['numTel'] : ""); ?>
    <div class="form-floating my-2">
	<input type="tel" id="disabledTextInput floatingInput"  class="form-control" name="numTel" required pattern="[0-9]{10}" placeholder="ex: 0649385748">
	<label class=text-muted">Numéro de téléphone <span class="text text-danger">*</span></label>
    </div>
    <?= radio('Avez-vous déjà passé le DELF-DALF ?', ['Oui', 'Non'], 'delfdalf', 'required'); ?>
    <div class="form" style="display: none;" id="ifOui">
      <?= input('text', 'Entrez obligatoirement votre ancien numéro candidat <span style="color: red";>*</span>', 'num_candidat', "", isset($_COOKIE['num_candidat']) ? $_COOKIE['num_candidat'] : ""); ?>
    </div>
    <?= radio('Quel niveau souhaitez-vous passer ?', ['DELF A1 (95 &euro;)', 'DELF A2 (115 &euro;)', 'DELF B1 (130 &euro;)', 'DELF B2 (155 &euro;)', 'DALF C1 (195 &euro;)', 'DALF C2 (195 &euro;)'], 'niveau2', 'required'); ?>
    <?= radio('Votre inscription est prise en charge par :', ['Vous', 'Association Accueil et culture ', 'Centre culturel Les Doucettes', 'Centre culturel Petit Colombes', 'Centre Zenith', 'AFPA'], 'priseEnCharge', 'required'); ?>
    <div class="input-group mb-3">
        <label class="input-group-text" for="formFileMultiple">Devant de votre pièce d'identité (PDF)</label>
        <input type="file" class="form-control" id="formFileMultiple" name="ci" required>
    </div>
    <div class="input-group mb-3">
        <label class="input-group-text" for="formFileMultiple2">Dos de votre pièce d'identité (PDF)</label>
        <input type="file" class="form-control" id="formFileMultiple2" name="ci_dos" required>
    </div>
    <?= radio('Traitement des données personnelles', ["J'ai lu et j'accepte la <a target='_blank' href='https://www.univ-paris13.fr/wp-content/uploads/DELF-DALF-Traitement-des-donnees-personnelles-1.pdf'>politique de traitement des données personnelles de l'Espace Langues de l'Université Sorbonne Paris Nord</a>."], 'donnees', 'required'); ?>
    <button class="w-100 btn btn-lg btn-primary" type="submit" id="submit">S'inscrire</button>
