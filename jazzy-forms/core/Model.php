<?php

require_once(JZZF_GENERATED . 'Basic_Model.php');

function jzzf_list_form_recursive() {
    $forms = jzzf_list_form();
    foreach( $forms as $form ) {
        $form->elements = jzzf_list_element($form->id);
    }
    return $forms;
}

function jzzf_edit_form_recursive($form) {
    return (object) array();
}