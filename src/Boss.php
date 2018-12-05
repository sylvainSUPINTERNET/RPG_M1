<?php
/**
 * Created by PhpStorm.
 * User: sylvainjoly
 * Date: 05/12/2018
 * Time: 10:06
 */

class Boss extends CharacterChar
{
    public $pic_name = "";



    public function __construct($nickname, $hereo, $atk, $hp, $pic_name, $mana)
    {
        $this->pic_name = $pic_name;

        parent::__construct($nickname, $hereo, $atk, $hp, $mana);
    }


    public function getPicPath()
    {
        return '../assets/character/image/'.$this->pic_name;
    }

    /**
     * @return string
     */
    public function getPicName()
    {
        return $this->pic_name;
    }

    /**
     * @param string $pic_name
     */
    public function setPicName($pic_name)
    {
        $this->pic_name = $pic_name;
    }




}