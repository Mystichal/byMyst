<?php

/**
 * Created by PhpStorm.
 * User: Mystichal
 * Date: 2017-11-13
 * Time: 23:21
 */
class business extends application
{

    # function to get business title
    public function getBusiness()
    {
        $this->database->connect();

        $this->database->select('business', '*', null, 'id="1"');
        $results = $this->database->getResult();

        $this->database->disconnect();
        return $results;
    }

    # function to get business current vat rate
    public function getVatRate()
    {
        $business = $this->getBusiness();
        return $business[0]['moms'];
    }
}
