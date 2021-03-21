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
		$urlEntity = UrlResolver::resolve($_SERVER['REQUEST_URI']);

		try {
			$urlEntity = ControllerResolver::findController($urlEntity);
			View::findView(ControllerResolver::getController(), $urlEntity);
		} catch (UrlException $e) {
			http_response_code($e->getCode());
		}

	}
}