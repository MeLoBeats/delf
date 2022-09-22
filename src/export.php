<?php
require_once '../src/bootstrap.php';

if(!is_admin()) {
    header('location: ../public');
    die;
}

header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename=Candidatures_'. date('d-M-Y') . '.csv');

// $select_table = db()->prepare('select * from formulaire ORDER BY form_id DESC;');
$select_table = db()->prepare('select form_id AS Form_No, nom AS Nom, prenom AS Prenom, date_naissance, ville_naissance, pays_naissance, nationalite, langue_mat AS Langue_Maternelle, email, deja_passer_delf, numero_candidat, niveau, prise_en_charge, date_rempli, paiement from formulaire ORDER BY form_id DESC;');
$select_table->execute();
$rows = $select_table->fetch();
$filename = 'Candidatures_'. date('d-M-Y') . '.csv';
if($rows) {
    makecsv(array_keys($rows));
}
while($rows) {
    makecsv($rows);
    $rows = $select_table->fetch();
}
function makecsv($num_field_name) {
    $separate = " ";
    foreach($num_field_name as $field_name) {
        $newField = str_replace( array("é", "è", "ç"), array('e', "e", "c"), $field_name);
        echo $separate . $newField;
        $separate = ';';
    }
    echo "\n\r";
}

