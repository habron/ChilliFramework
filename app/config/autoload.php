<?php

require_once __DIR__ . "/consts.php";

//Core
require_once __DIR__ . "/../core/controller/Controller.php";
require_once __DIR__ . "/../core/controller/ControllerResolver.php";
require_once __DIR__ . "/../core/url/UrlResolver.php";
require_once __DIR__ . "/../core/view/View.php";

//Exception
require_once __DIR__ . "/../exception/UrlException.php";

//Controllers
require_once __DIR__ . "/../controllers/BaseController.php";
require_once __DIR__ . "/../controllers/HomepageController.php";

//Views
require_once __DIR__ . "/../views/Homepage/default.php";