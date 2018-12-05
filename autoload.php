<?php
/**
 * Created by PhpStorm.
 * User: sylvainjoly
 * Date: 05/12/2018
 * Time: 09:40
 */


spl_autoload_register(function($class){
    require __DIR__.'/src/'.$class . '.php';
});
