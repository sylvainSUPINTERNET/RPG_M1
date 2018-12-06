<?php
/**
 * Created by PhpStorm.
 * User: sylvainjoly
 * Date: 04/12/2018
 * Time: 14:09
 */

class Inventory
{

    protected $inventory; // array of Items object

    public function __construct()
    {
        $this->initInventory();
    }


    public function  initInventory(){
        if(isset($_SESSION["inventory"])){
            $this->setInventory($_SESSION["inventory"]);
        } else {
            $this->setInventory($_SESSION["inventory"] = []);
        }
    }

    /**
     * @return mixed
     */
    public function getInventory()
    {
        return $this->inventory;
    }

    /**
     * @param $inventory
     */
    public function setInventory($inventory)
    {
        $this->inventory = $inventory;
    }


    //Add item type Item in inventory
    public function addItem($Item)
    {
        $current_inventory = $this->getInventory();
        array_push($current_inventory, $Item);
        $this->setInventory($current_inventory);
        $_SESSION["inventory"] = $this->getInventory();
    }




}