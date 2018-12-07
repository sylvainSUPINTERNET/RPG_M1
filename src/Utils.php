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


    //return hard value of the most expensive mana cost to avoid the cast and get negative mana amount during the fight
    static function mostExpensiveBossSpell(){
        return $_MAX_MANA_COST = 300;
    }

    static function getRandom($min, $max){
        return rand($min, $max);
    }

    static function clearDialogProcItemChar(){
        if(isset($_SESSION["ITEMS_PROC_DIALOG"])){
            $_SESSION["ITEMS_PROC_DIALOG"] = "";
        }
    }


    static function clearDialogBossSpell(){
        if(isset($_SESSION["SPELL_BOSS_CAST"])){
            $_SESSION["SPELL_BOSS_CAST"] = "";
        }
    }

    public static function clearDialogSkill()
    {
        if(isset($_SESSION["SKILL_DIALOG"])){
            $_SESSION["SKILL_DIALOG"] = "";
        }
    }


}