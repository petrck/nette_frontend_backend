<?php

namespace App\FrontendModule\Presenters;

use App\Frontend\Model\DatabaseDriver;
use Nette,
	App\Model;


/**
 * Homepage presenter.
 */
class HomepagePresenter extends BasePresenter
{

    /** @var DatabaseDriver @inject */
    public $database;

	public function renderDefault()
	{
		$this->template->anyVariable = 'any value';
	}

}
