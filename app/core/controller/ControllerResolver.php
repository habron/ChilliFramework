<?php
declare(strict_types=1);

namespace core\controller;

use core\di\Container;
use core\url\UrlEntity;
use Exception;
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

	const NO_DEFAULT_VALUE = "!c5#re@f5GR5g6!ů§de";

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
	 * @param UrlEntity $urlEntity
	 * @return UrlEntity
	 * @throws UrlException
	 */
	public static function findController(UrlEntity $urlEntity): UrlEntity
	{
		$class = CONTROLLERS_NAMESPACE . $urlEntity->getController() . "Controller";
		if (!class_exists($class)) {
			if ($urlEntity->getController() != "Error") {
				$errorEntity = new UrlEntity("Error", "404", $urlEntity->getParams());
				self::findController($errorEntity);
				return $errorEntity;
			} else {
				throw new UrlException("Page not found!", 404);
			}
		}

		try {
			$instance = Container::createObject($class);
		} catch (Exception $e) {
			$instance = null;
		}
		if ($instance == null || $instance instanceof Controller == false) {
			if ($urlEntity->getController() != "Error") {
				$errorEntity = new UrlEntity("Error", "404", $urlEntity->getParams());
				self::findController($errorEntity);
				return $errorEntity;
			} else {
				throw new UrlException("Controller is not child of core\controller\Controller!", 404);
			}
		}
		self::$controller = $instance;
		self::$controller->startup();

		$methodAction = "action" . $urlEntity->getAction();
		$methodRender = "render" . $urlEntity->getAction();

		if (method_exists(self::$controller, $methodAction)) {
			self::callMethod(self::$controller, $methodAction, $urlEntity->getParams());
		}
		if (method_exists(self::$controller, $methodRender)) {
			self::callMethod(self::$controller, $methodRender, $urlEntity->getParams());
		}

		return $urlEntity;

	}


	/**
	 * Call controller mathod
	 * @param Controller $controller
	 * @param string $name
	 * @param string[] $params
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
		foreach ($args as $arg => $defaultVal) {
			if (!isset($params[$arg]) && $defaultVal == self::NO_DEFAULT_VALUE) {
				throw new UrlException("Missing argument!", 404);
			}
			$parameters[$arg] = $params[$arg] ?? $defaultVal;
		}

		call_user_func_array(array($controller, $name), $parameters);
	}


	/**
	 * Returns function arguments
	 * @param Controller $controller
	 * @param string $funcName
	 * @return string[]
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
			try {
				$result[$param->name] = $param->getDefaultValue();
			} catch (ReflectionException $e) {
				$result[$param->name] = self::NO_DEFAULT_VALUE;
			}
		}
		return $result;
	}
}
