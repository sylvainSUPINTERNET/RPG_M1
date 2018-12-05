<?php
/**
 * Created by PhpStorm.
 * User: sylvainjoly
 * Date: 05/12/2018
 * Time: 11:56
 */

class Utils
{

    public function __construct()
    {
    }


    static function getRandom($min, $max){
        return rand($min, $max);
    }
}