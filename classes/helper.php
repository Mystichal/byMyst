<?php

/**
 * Created by PhpStorm.
 * User: Mystichal
 * Date: 2017-11-13
 * Time: 23:21
 */
class helper
{
    # function to get the current url
    public static function getActive($page = null)
    {
        if (!empty($page)) {
            if (is_array($page)) {
                $error = array();
                foreach ($page as $key => $value) {
                    if (url::getParam($key) != $value) {
                        array_push($error, $key);
                    }
                }
                return empty($error) ? " class=\"act\"" : null;
            }
        }
        return $page == url::cPage() ? " class=\"act\"" : null;
    }
}
