<?php

require_once "router.php";

route('/', function () {
    header("Location: homepage.php");
});

route('/about', function () {
    return "Hello from the about route";
});

route('/danceEvent', function () {
    header("Location: views/danceEvent.php");
});

$action = $_SERVER['REQUEST_URI'];
dispatch($action);

?>