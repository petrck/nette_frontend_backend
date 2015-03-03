<?php

namespace App\Frontend\Model;

use Nette;

/**
 * Database Driver
 * @param Nette\Database\Context
 * @param String
 */

class DatabaseDriver
{

    /* @var Nette\Database\Context */
    private $database;


    public function __construct(Nette\Database\Context $database, $wwwDir)
    {
        $this->database = $database;

    }
}


