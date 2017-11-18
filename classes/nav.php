<?php

/**
 * Created by PhpStorm.
 * User: Mystichal
 * Date: 2017-11-13
 * Time: 23:21
 */
class nav extends application
{
    public function getCategories()
    {
        $this->database->connect();

        $this->database->select('categories', '*', null, null, 'id ASC');
        $results = $this->database->getResult();

        $this->database->disconnect();
        return $results;
    }
}
