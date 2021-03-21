<?php
declare(strict_types=1);

namespace core\view;


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
	 * @param string $controllerName
	 * @param string $actionName
	 * @throws UrlException
	 */
	public static function findView(string $controllerName, string $actionName): void
	{
		$viewName = \strtolower($actionName);
		$viewPath = \VIEW_DIR . $controllerName . "/" . $viewName . ".php";
		if (!\file_exists($viewPath)) {
			throw new UrlException("View file is missing!");
		}
	}
}
