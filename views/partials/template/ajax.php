<?php
if (isset($_POST['itemid'])){
    $result = App::get('database')->getProduct($_POST['itemid']);
    echo json_encode($result);
}