<?php
declare(strict_types=1);

namespace core\view;


use core\controller\Controller;
use core\url\UrlEntity;
use exception\UrlException;

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

		echo self::renderView($viewPath, (array)$controller->getTemplate());

	}


	/**
	 * Render view
	 * @param string $path
	 * @param array $params
	 * @return string
	 */
	private static function renderView(string $path, array $params): string
	{
		ob_start();
		include($path);
		$var = ob_get_contents();
		ob_end_clean();
		return $var;
	}
}
