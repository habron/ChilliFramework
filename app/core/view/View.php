<?php
declare(strict_types=1);

namespace core\view;


use core\controller\Controller;
use core\url\UrlEntity;
use exception\UrlException;
use stdClass;

/**
 * Class used to resolve the view
 *
 * @author ondra
 */
class View
{


	/**
	 * Finds view
	 * @param Controller $controller
	 * @param UrlEntity $urlEntity
	 * @throws UrlException
	 */
	public static function findView(Controller $controller, UrlEntity $urlEntity): void
	{
		$viewName = \strtolower($urlEntity->getAction());
		$viewPath = VIEW_DIR . $urlEntity->getController() . "/" . $viewName . ".php";
		if (!\file_exists($viewPath)) {
			throw new UrlException("View file is missing!", 404);
		}

		self::renderView($viewPath, $controller->getTemplate());
	}


	/**
	 * Render view
	 * @param string $path
	 * @param StdClass $template
	 */
	private static function renderView(string $path, StdClass $template): void
	{
		ob_start();
		include ($path);
		ob_end_flush();
	}

}
