<?php
/**
 * Created by PhpStorm.
 * User: sylvainjoly
 * Date: 05/12/2018
 * Time: 14:34
 */

class TurnManager
{

    public $played;


    public function __construct(){

        $this->played = false;
    }

    public function charAttacked(){
        $this->setPlayed(true);
        $_SESSION["attacked"] = $this->isPlayed();
    }

    public function bossAttacked(){
        $this->setPlayed(false); //reset for user
        $_SESSION["attacked"] = $this->isPlayed();
    }

    /**
     * @return bool
     */
    public function isPlayed()
    {
        return $this->played;
    }

    /**
     * @param bool $played
     */
    public function setPlayed($played)
    {
        $this->played = $played;
    }


}