<?php
/**
 * Created by PhpStorm.
 * User: sylvainjoly
 * Date: 04/12/2018
 * Time: 13:56
 */

abstract class ActionChar
{

    abstract function attack( $attaquant, $target, $typeAttquant); //basic attack both (boss / char)
    abstract function specialAttack($attaquant, $target); //item
    abstract function skillAttack($attaquant, $target, $skillEffect, $manaCost); //attack from skills (char)
    abstract function regenMana(); //call on each type attack (boss /char)

}