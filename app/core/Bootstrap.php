<?php
declare(strict_types=1);

namespace core;


use core\controller\ControllerResolver;
use core\url\UrlResolver;
use core\view\View;
use exception\UrlException;

/**
 * Class Bootstrap
 * @package core
 * @author ondra
 */
class Bootstrap
{


	/**
	 * Boot application
	 */
	public static function boot(): void
	{
		UrlResolver::resolve($_SERVER['REQUEST_URI']);
		try {
			ControllerResolver::findController(UrlResolver::getController(), UrlResolver::getAction(), UrlResolver::getParams());
			View::findView(UrlResolver::getController(), UrlResolver::getAction());
		} catch (UrlException $e) {
			http_response_code(404);
			exit;
		}
	}
}