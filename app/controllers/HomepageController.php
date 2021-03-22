<?php
declare(strict_types=1);

namespace controllers;

use database\Reports;
use DateTime;
use Exception;

/**
 * Homepage controller
 * @author ondra
 */
class HomepageController extends BaseController
{

	/** @var Reports */
	private Reports $reports;


	/**
	 * HomepageController constructor.
	 * @param Reports $reports
	 */
	public function __construct(Reports $reports)
	{
		parent::__construct();
		$this->reports = $reports;
	}


	/**
	 * @param string $date
	 */
	public function renderDefault(string $date = ""): void
	{
		try {
			$date = !empty($date) ? new DateTime($date) : null;
			$this->template->date = $date->format("d.m.Y");
		} catch (Exception $e) {
			$date = null;
		}
		$this->template->reports = $this->reports->getReports($date);
		$this->template->lastReport = $this->reports->getLastReport();
	}
}
