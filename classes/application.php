<?php

/**
 * Created by PhpStorm.
 * User: Mystichal
 * Date: 2017-11-13
 * Time: 23:21
 */
class application
{

    public $database;

    /**
     * application constructor.
     */
    public function __construct()
    {
        $this->database = new database();
    }
}
