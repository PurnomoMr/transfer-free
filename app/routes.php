<?php

include(PATH_ROOT."/core/Router.php");
$path = trim($_SERVER['REQUEST_URI']);
$path = parse_url($path, PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

Router::get("/", "Bank/get_status");
Router::get("/transfer/status", "disborse/check");
Router::post("/transfer", "user_disborse/send");

require Router::run($method, $path);