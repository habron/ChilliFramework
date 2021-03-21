<?php
declare(strict_types=1);

namespace model;


use DateTime;

/**
 * Class Report
 * @package model
 * @author ondra
 */
class Report
{

	/** @var int */
	private int $id;

	/** @var float */
	private float $temperature;

	/** @var float */
	private float $soilHumidity;

	/** @var float */
	private float $airHumidity;

	/** @var DateTime */
	private DateTime $dateTime;


	/**
	 * Report constructor.
	 * @param int $id
	 * @param float $temperature
	 * @param float $soilHumidity
	 * @param float $airHumidity
	 * @param DateTime $dateTime
	 */
	public function __construct(int $id, float $temperature, float $soilHumidity, float $airHumidity, DateTime $dateTime)
	{
		$this->id = $id;
		$this->temperature = $temperature;
		$this->soilHumidity = $soilHumidity;
		$this->airHumidity = $airHumidity;
		$this->dateTime = $dateTime;
	}


	/**
	 * @return int
	 */
	public function getId(): int
	{
		return $this->id;
	}


	/**
	 * @return float
	 */
	public function getTemperature(): float
	{
		return $this->temperature;
	}


	/**
	 * @return float
	 */
	public function getSoilHumidity(): float
	{
		return $this->soilHumidity;
	}


	/**
	 * @return float
	 */
	public function getAirHumidity(): float
	{
		return $this->airHumidity;
	}


	/**
	 * @return DateTime
	 */
	public function getDateTime(): DateTime
	{
		return $this->dateTime;
	}

}
