<?php
declare(strict_types=1);

namespace core\di;


use Exception;
use InvalidArgumentException;
use ReflectionClass;
use ReflectionException;

/**
 * Class Container
 * @package core\di
 * @author ondra
 */
class Container
{

	private static array $services = [];


	/**
	 * Returns dependency object
	 * @param string $name
	 * @return object
	 * @throws InvalidArgumentException
	 */
	public static function getDependency(string $name): object
	{
		if (!class_exists($name)) {
			throw new InvalidArgumentException("Class not found");
		}

		if (isset(self::$services[$name])) {
			return self::$services[$name];
		}

		try {
			$class = self::createObject($name);
			self::$services[$name] = $class;
			return $class;
		} catch (Exception $e) {
			throw new InvalidArgumentException("Class not found");
		}

	}


	/**
	 * Creates new instance of object
	 * @param string $name
	 * @return object
	 * @throws ReflectionException
	 * @throws InvalidArgumentException
	 */
	public static function createObject(string $name): object
	{
		if (!class_exists($name)) {
			throw new InvalidArgumentException("Class not found");
		}

		$class = new ReflectionClass($name);
		$constructor = $class->getConstructor();
		$params = $constructor->getParameters();

		$args = [];
		foreach ($params as $param) {
			$args[$param->getName()] = self::getDependency($param->getClass()->name);
		}

		return $class->newInstanceArgs($args);
	}
}