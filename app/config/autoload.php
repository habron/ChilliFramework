<?php
declare(strict_types=1);

require_once __DIR__ . "/../../vendor/autoload.php";

use Tracy\Debugger;

Debugger::enable(Debugger::DEVELOPMENT);

//Config
require_once __DIR__ . "/consts.php";

//Core
require_once __DIR__ . "/../core/Bootstrap.php";
require_once __DIR__ . "/../core/controller/Controller.php";
require_once __DIR__ . "/../core/controller/ControllerResolver.php";
require_once __DIR__ . "/../core/database/Connection.php";
require_once __DIR__ . "/../core/di/Container.php";
require_once __DIR__ . "/../core/url/UrlEntity.php";
require_once __DIR__ . "/../core/url/UrlResolver.php";
require_once __DIR__ . "/../core/view/View.php";

//Database
require_once __DIR__ . "/../database/Reports.php";

//Exception
require_once __DIR__ . "/../exception/UrlException.php";

//Controllers
require_once __DIR__ . "/../controllers/BaseController.php";
require_once __DIR__ . "/../controllers/ErrorController.php";
require_once __DIR__ . "/../controllers/HomepageController.php";

//Model
require_once __DIR__ . "/../model/Report.php";

//Views
require_once __DIR__ . "/../views/Homepage/default.php";
