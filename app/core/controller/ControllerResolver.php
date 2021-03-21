<?php
declare(strict_types=1);

namespace core\controller;

use exception\UrlException;
use ReflectionException;
use ReflectionMethod;
use function method_exists;

/**
 * Class used to find the controller
 *
 * @author ondra
 */
class ControllerResolver
{

	/** @var Controller */
	private static Controller $controller;


	/**
	 * @return Controller
	 */
	public static function getController(): Controller
	{
		return self::$controller;
	}


	/**
	 * Finds controller
	 * @param string $controllerName
	 * @param string $actionName
	 * @param array $params
	 * @return void
	 * @throws UrlException
	 */
	public static function findController(string $controllerName, string $actionName, array $params): void
	{
		$class = CONTROLLERS_NAMESPACE . $controllerName . "Controller";
		if (!class_exists($class)) {
			throw new UrlException("Page not found!");
		}

		self::$controller = new $class(); //TODO Solve constructor dependencies
		if (self::$controller instanceof Controller == false) {
			throw new UrlException("Controller is not child of App\Core\Controller\Controller!");
		}
		self::$controller->startup();

		$methodAction = "action" . $actionName;
		$methodRender = "render" . $actionName;

		if (method_exists(self::$controller, $methodAction)) {
			self::callMethod(self::$controller, $methodAction, $params);
		}
		if (method_exists(self::$controller, $methodRender)) {
			self::callMethod(self::$controller, $methodRender, $params);
		}

	}


	/**
	 * Call controller mathod
	 * @param Controller $controller
	 * @param string $name
	 * @param array $params
	 * @return void
	 * @throws UrlException
	 */
	private static function callMethod(Controller $controller, string $name, array $params): void
	{
		if (!method_exists($controller, $name)) {
			throw new UrlException("Action not found!");
		}

		$args = self::getFuncArgNames($controller, $name);

		$parameters = [];
		foreach ($args as $arg) {
			if (!isset($params[$arg])) {
				throw new UrlException("Missing argument!");
			}
			$parameters[$arg] = $params[$arg];
		}

		call_user_func_array(array($controller, $name), $parameters);
	}


	/**
	 * Returns function arguments
	 * @param Controller $controller
	 * @param string $funcName
	 * @return array
	 */
	private static function getFuncArgNames(Controller $controller, string $funcName): array
	{
		try {
			$f = new ReflectionMethod(get_class($controller), $funcName);
		} catch (ReflectionException $e) {
			return [];
		}
		$result = array();
		foreach ($f->getParameters() as $param) {
			$result[] = $param->name;
		}
		return $result;
	}
}
