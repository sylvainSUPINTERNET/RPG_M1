<?php
/**
 * Created by PhpStorm.
 * User: sylvainjoly
 * Date: 07/12/2018
 * Time: 12:19
 */

class Skill
{

    protected $name;
    protected $mana_cost;
    protected $effect;
    protected $icon;
    protected $description;



    public function __construct($name, $mana_cost, $effect, $icon, $description)
    {
        $this->name = $name;
        $this->mana_cost = $mana_cost;
        $this->effect = $effect;
        $this->icon = $icon;
        $this->description = $description;
    }


    /**
     * @return mixed
     */
    public function getEffect()
    {
        return $this->effect;
    }

    /**
     * @param mixed $effect
     */
    public function setEffect($effect)
    {
        $this->effect = $effect;
    }

    /**
     * @return mixed
     */
    public function getManaCost()
    {
        return $this->mana_cost;
    }

    /**
     * @param mixed $mana_cost
     */
    public function setManaCost($mana_cost)
    {
        $this->mana_cost = $mana_cost;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @param mixed $icon
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }


    //check every character turn which skills is available compare with his mana amount
    static public function checkManaAmount($sessionCharacter, $sessionSkills){
        $current_char_mana = $sessionCharacter->getMana();

        $skill1_mana_cost = $sessionSkills[0]->getManaCost();
        $skill2_mana_cost = $sessionSkills[1]->getManaCost();
        $skill3_mana_cost = $sessionSkills[2]->getManaCost();

        $skills_enable = [];

        if($current_char_mana - $skill1_mana_cost >= 0){
            array_push($skills_enable,0);
        }

        if($current_char_mana - $skill2_mana_cost >= 0){
            array_push($skills_enable,1);
        }

        if($current_char_mana - $skill3_mana_cost >= 0){
            array_push($skills_enable,2);
        }

        return $skills_enable;

    }


}