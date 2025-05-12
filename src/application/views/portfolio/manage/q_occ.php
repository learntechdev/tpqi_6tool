<?php
if (isset($_GET['template_id'])) {
    $tmp_tp_id = $_GET['template_id'];
} else {
    $tmp_tp_id = '';
}

$this->load->view("templates/chklist_occ_mainsubtopic",
    array(
        "initial" => "1",
        "initial_sub" => "1",
        "template_id" => $template,
    ));
    ?>