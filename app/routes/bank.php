<?php

include(PATH_ROOT."core/Router.php");
$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

Router::get("/", "Bank/get_status/");
require Router::run($path);