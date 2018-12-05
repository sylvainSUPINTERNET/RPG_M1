<?php
/**
 * Created by PhpStorm.
 * User: sylvainjoly
 * Date: 04/12/2018
 * Time: 13:56
 */

abstract class ActionChar
{
    //private $atk;


    abstract function attack( $attaquant, $target);
    abstract function specialAttack($attaquant, $target);


    /**
    public function getAtk(){

    }

    public function setAtk(){
    }
     **/

}