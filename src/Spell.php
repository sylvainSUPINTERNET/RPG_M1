<?php
/**
 * Created by PhpStorm.
 * User: sylvainjoly
 * Date: 05/12/2018
 * Time: 12:16
 */

class Spell
{

    public function __construct()
    {
    }


    //when attack and user got items, proc of buff
    static function makeProcEffect($dialogProc, $sessionAttaquant, $sessionTarget)
    {

        //switch on dialog and set the SESSION to corresponding
        //Check before use dont spam refresh to get buff

        switch ($dialogProc) {
            case "Critical strike ! ":
                $a_atk = $sessionAttaquant->getAtk() * 2;
                $t_hp = $sessionTarget->getHp();
                $sessionTarget->setHp($t_hp - $a_atk);
                $_SESSION["ITEMS_PROC_DIALOG"] = "Critical strike !";
                break;
            case "B U I L D":
                $bonus_hp = $sessionAttaquant->getHp() + 40;
                $sessionAttaquant->setHp($bonus_hp);
                $_SESSION["ITEMS_PROC_DIALOG"] = "BUILD WALL";
                break;
            case "Get heal !":
                $heal = $sessionAttaquant->getHp() + 50;
                $sessionAttaquant->setHp($heal);
                $_SESSION["ITEMS_PROC_DIALOG"] = "Get heal !";
                break;
            case "You are too cool !":
                $heal = $sessionAttaquant->getHp() + 50;
                $dmg_boost = $sessionAttaquant->getBaseAtk() + 50 + $sessionAttaquant->getAtk();

                $sessionAttaquant->setHealth($heal);
                $sessionAttaquant->setAtk($dmg_boost);

                $_SESSION["ITEMS_PROC_DIALOG"] = "You are too cool, damage boosted !";
                break;
            case 'Ragnaros : BY FIRE BE PURGED!':
                $dmg_boost = $sessionAttaquant->getBaseAtk() + 25 + $sessionAttaquant->getAtk();
                $sessionAttaquant->setAtk($dmg_boost);
                $_SESSION["ITEMS_PROC_DIALOG"] = "* Ragnaros * BY FIRE BE PURGED!";
                break;
            case 'WoW = casu':
                $dmg_boost = $sessionAttaquant->getBaseAtk() + 30 + $sessionAttaquant->getAtk();
                $health_boost = $sessionAttaquant->getHpBase() + 30 + $sessionAttaquant->getHp();

                $sessionAttaquant->setAtk($dmg_boost);
                $sessionAttaquant->setHp($health_boost);

                $_SESSION["ITEMS_PROC_DIALOG"] = "* Kungen * Actually, WoW is casu af";
                break;
            case 'Thunder strike !':
                $dmg_boost_op = $sessionAttaquant->getAtk() + 30;
                $sessionAttaquant->setAtk($dmg_boost_op);
                $_SESSION["ITEMS_PROC_DIALOG"] = "Thunder strike !";
                break;
            case 'G O D':
                $dmg_boost_op = $sessionAttaquant->getAtk() + 100;
                $sessionAttaquant->setAtk($dmg_boost_op);
                $_SESSION["ITEMS_PROC_DIALOG"] = "G O D";
                break;
            case '1st world G\'huun.':
                $dmg_boost_op = $sessionAttaquant->getAtk() + 50;
                $dmg_health_op = $sessionAttaquant->getHp() + 50;
                $sessionAttaquant->setAtk($dmg_boost_op);
                $sessionAttaquant->setHp($dmg_health_op);
                $_SESSION["ITEMS_PROC_DIALOG"] = "1st world G'huun.";
                break;
            default:
                $_SESSION["ITEMS_PROC_DIALOG"] = "";
                break;
        }
    }



    //BECAREFULL already +50 each turn with the regen mana
    static public function bossSpell($sessionBoss, $sessionCharacter)
    {

        $SPELLS_KT = [
            0 => ["frost bolt", "//icon path", 250, 250],
            1 => ["frost cage", "//icon path", 60, 200],
        ];

        $SPELLS_ARTHAS = [
            0 => ["infested", "//icon path", 500, 200],
            1 => ["blood pact", "//icon path", 90, 150],
        ];

        $SPELLS_ILLIDAN = [
            0 => ["azzinoth flames", "//icon path", 150, 250],
            1 => ["furry", "//icon path", 40, 200],
        ];

        $rand = Utils::getRandom(0, 1);

        var_dump("BOSS RANDOM SPELL");
        var_dump($sessionBoss->getMana());

        if($sessionBoss->getMana() >= 100){
            if($sessionBoss->getHereo() === "Kel'Thuzad"){
                $SPELLS_KT[$rand];
                $spell_name = $SPELLS_KT[$rand][0];
                $spell_icon = $SPELLS_KT[$rand][1];
                $spell_dmg = $SPELLS_KT[$rand][2];
                $spell_mana = $SPELLS_KT[$rand][3];



                $_SESSION["SPELL_BOSS_CAST"] = [
                    "name" => $spell_name,
                    "icon" => $spell_icon,
                    "dmg" => $spell_dmg,
                    "mana_cost" => $spell_mana
                ];

                //damage taken
                $total_dmg = $sessionBoss->getAtk() + $_SESSION["SPELL_BOSS_CAST"]["dmg"];
                $sessionCharacter->setHp($sessionCharacter->getHp() - $total_dmg);

                //mana cost
                $remainMana = $sessionBoss->getMana() - $spell_mana;
                $sessionBoss->setMana($remainMana);

                var_dump("CAST ? => ", $_SESSION["SPELL_BOSS_CAST"]["name"]);
                var_dump("MANA COST ? => ", $_SESSION["SPELL_BOSS_CAST"]["mana_cost"]);
                var_dump("BOSS MANA REMAINS",$sessionBoss->getMana());


            } else if($sessionBoss->getHereo() === "Arthas"){
                $SPELLS_ARTHAS[$rand];
                $spell_name = $SPELLS_ARTHAS[$rand][0];
                $spell_icon = $SPELLS_ARTHAS[$rand][1];
                $spell_dmg = $SPELLS_ARTHAS[$rand][2];
                $spell_mana = $SPELLS_KT[$rand][3];


                $_SESSION["SPELL_BOSS_CAST"] = [
                    "name" => $spell_name,
                    "icon" => $spell_icon,
                    "dmg" => $spell_dmg,
                    "mana_cost" => $spell_mana

                ];

                $total_dmg = $sessionBoss->getAtk() + $_SESSION["SPELL_BOSS_CAST"]["dmg"];
                $sessionCharacter->setHp($sessionCharacter->getHp() - $total_dmg);

                //mana cost
                $remainMana = $sessionBoss->getMana() - $spell_mana;
                $sessionBoss->setMana($remainMana);

                var_dump("CAST ? => ", $_SESSION["SPELL_BOSS_CAST"]["name"]);
                var_dump("MANA COST ? => ", $_SESSION["SPELL_BOSS_CAST"]["mana_cost"]);
                var_dump("BOSS MANA REMAINS",$sessionBoss->getMana());


            }else{
                $SPELLS_ILLIDAN[$rand];
                $spell_name = $SPELLS_ILLIDAN[$rand][0];
                $spell_icon = $SPELLS_ILLIDAN[$rand][1];
                $spell_dmg = $SPELLS_ILLIDAN[$rand][2];
                $spell_mana = $SPELLS_KT[$rand][3];


                $_SESSION["SPELL_BOSS_CAST"] = [
                    "name" => $spell_name,
                    "icon" => $spell_icon,
                    "dmg" => $spell_dmg,
                    "mana_cost" => $spell_mana

                ];

                $total_dmg = $sessionBoss->getAtk() + $_SESSION["SPELL_BOSS_CAST"]["dmg"];
                $sessionCharacter->setHp($sessionCharacter->getHp() - $total_dmg);

                //mana cost
                $remainMana = $sessionBoss->getMana() - $spell_mana;
                $sessionBoss->setMana($remainMana);
                var_dump("CAST ? => ", $_SESSION["SPELL_BOSS_CAST"]["name"]);
                var_dump("MANA COST ? => ", $_SESSION["SPELL_BOSS_CAST"]["mana_cost"]);
                var_dump("BOSS MANA REMAINS",$sessionBoss->getMana());


            }
        }
    }

    static public function charSpell($sessionUser, $sessionBoss)
    {
        if ($sessionUser->getHereo() === "asmongod") {
            var_dump("ASMONGOD");
            var_dump("current user mana for spell -> ", $sessionUser->getMana());
        } else if ($sessionUser->getHereo() === "leeroy") {
            var_dump("LEEROY");
            var_dump("current user mana for spell -> ", $sessionUser->getMana());
        }
    }

}