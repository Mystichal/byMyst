<?php

/**
 * Created by PhpStorm.
 * User: Mystichal
 * Date: 2017-11-13
 * Time: 23:21
 */
class core
{

    public function run()
    {
        ob_start();
        require_once(url::getPage());
        ob_get_flush();
    }
}
