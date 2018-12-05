<?php
/**
 * Created by PhpStorm.
 * User: sylvainjoly
 * Date: 04/12/2018
 * Time: 13:49
 */

class Item {


    protected $name = "";
    protected $stat_atk = 0;
    protected $stat_health = 0;

    protected $item_icon_name = "";


    //todo
    protected $stat_special = "";
    protected $stat_special_icon = "";

    public function __construct($name, $stat_atk, $stat_health,$stat_special, $icon_name, $stat_special_icon_name)
    {
        $this->name = $name;
        $this->stat_atk = $stat_atk;
        $this->stat_health = $stat_health;
        $this->stat_special = $stat_special;
        $this->item_icon_name = $icon_name;
        $this->stat_special_icon = $stat_special_icon_name;

    }


    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }


    /**
     * @return int
     */
    public function getStatAtk()
    {
        return $this->stat_atk;
    }

    /**
     * @param int $stat_atk
     */
    public function setStatAtk($stat_atk)
    {
        $this->stat_atk = $stat_atk;
    }

    /**
     * @return int
     */
    public function getStatHealth()
    {
        return $this->stat_health;
    }

    /**
     * @param int $stat_health
     */
    public function setStatHealth($stat_health)
    {
        $this->stat_health = $stat_health;
    }

    /**
     * @return string
     */
    public function getStatSpecial()
    {
        return $this->stat_special;
    }

    /**
     * @param string $stat_special
     */
    public function setStatSpecial($stat_special)
    {
        $this->stat_special = $stat_special;
    }

    /**
     * @return string
     */
    public function getItemIconName()
    {
        return '../assets/items/'.$this->item_icon_name;
    }

    /**
     * @param string $item_icon
     */
    public function setItemIconName($item_icon)
    {
        $this->item_icon_name = $item_icon;
    }

    /**
     * @return string
     */
    public function getStatSpecialIcon()
    {
        return '../assets/items/stat_special/'.$this->stat_special_icon;

    }

    /**
     * @param string $stat_special_icon
     */
    public function setStatSpecialIcon($stat_special_icon)
    {
        $this->stat_special_icon = $stat_special_icon;
    }


}