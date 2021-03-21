<?php
declare(strict_types=1);

namespace controllers;

use database\Reports;

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


	public function renderDefault(): void
	{

	}
}
