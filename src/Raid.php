<?php
/**
 * Created by PhpStorm.
 * User: sylvainjoly
 * Date: 05/12/2018
 * Time: 10:06
 */

class Raid
{
    public $name = "";
    public $table_items = [];


    public function __construct($name)
    {
        $this->name = $name;
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



    public function setTableItems($arr){ //array of Item object
        $this->table_items = $arr;
    }

    public function getTableItems(){
        return $this->table_items; //array of Item object
    }



}