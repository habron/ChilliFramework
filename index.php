<?php
declare(strict_types=1);

require_once __DIR__ . "/app/config/autoload.php";

use App\Core\Controller\ControllerResolver;
use App\Core\Url\UrlResolver;
use App\Exception\UrlException;

//TODO Create RobotLoader
UrlResolver::resolve($_SERVER['REQUEST_URI']);
try {
    ControllerResolver::findController(UrlResolver::getController(), UrlResolver::getAction(), UrlResolver::getParams());
} catch (UrlException $e) {
    http_response_code(404);    
    exit;
}

