<?php
declare(strict_types=1);

namespace core\url;


/**
 * Class UrlEntity
 * @package core\url
 * @author ondra
 */
class UrlEntity
{

	/** @var string */
	private string $controller;

	/** @var string */
	private string $action;

	/** @var array */
	private array $params;


	/**
	 * UrlEntity constructor.
	 * @param string $controller
	 * @param string $action
	 * @param array $params
	 */
	public function __construct(string $controller, string $action, array $params)
	{
		$this->controller = $controller;
		$this->action = $action;
		$this->params = $params;
	}


	/**
	 * @return string
	 */
	public function getController(): string
	{
		return $this->controller;
	}


	/**
	 * @return string
	 */
	public function getAction(): string
	{
		return $this->action;
	}


	/**
	 * @return array
	 */
	public function getParams(): array
	{
		return $this->params;
	}

}