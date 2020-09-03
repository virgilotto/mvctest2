<?php
    session_unset();
    require_once  'controller/UserController.php';
    $controller = new UserController();
    $controller->mvcHandler();
?>