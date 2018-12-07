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


    //return text dialog in alert for item proc effet / bonus
    static function makeItemProcDialogLayout($item){
        $layout = "";

        $qt = $item->getQuality();
        switch ($qt){
            case "green":
                $layout = '<span style="color: limegreen;" class="mb-2 mt-2">['. $item->getName() .']</span><br><span>'.$item->getStatSpecial() . ' : '. $item->getItemBuffProcDialog() .'
                </span>';
                break;
            case "blue":
                $layout = '<span style="color: royalblue;" class="mb-2 mt-2">['. $item->getName() .']</span><br><span>'.$item->getStatSpecial(). ' : '. $item->getItemBuffProcDialog() .'
                </span>';
                break;
            case "purple":
                $layout = '<span style="color: rebeccapurple;" class="mb-2 mt-2">['. $item->getName() .']</span><br><span>'.$item->getStatSpecial(). ' : '. $item->getItemBuffProcDialog().'
                </span>';
                break;
            case "orange":
                $layout = '<span style="color: orange;" class="mb-2 mt-2">['. $item->getName() .']</span><br><span>'.$item->getStatSpecial(). ' : '. $item->getItemBuffProcDialog().'
                </span>';
                break;
            default:
                $layout = '<span style="color: black;" class="mb-2 mt-2">['. $item->getName() .']</span><br><span>'.$item->getStatSpecial(). ' : '. $item->getItemBuffProcDialog() .'
                </span>';
                break;
        }

        return $layout;
    }

    //when attack and user got items, proc of buff dialog AND effect
    static function makeProcEffect($statSpecial, $sessionAttaquant, $sessionTarget, $item)
    {

        //switch on dialog and set the SESSION to corresponding
        //Check before use dont spam refresh to get buff

        switch ($statSpecial) {
            case "Critical strike":
                $a_atk = $sessionAttaquant->getAtk() * 2;
                $t_hp = $sessionTarget->getHp();
                $sessionTarget->setHp($t_hp - $a_atk);
                $_SESSION["ITEMS_PROC_DIALOG"] = Spell::makeItemProcDialogLayout($item);
                break;
            case "B U I L D":
                $bonus_hp = $sessionAttaquant->getHp() + 40;
                $sessionAttaquant->setHp($bonus_hp);
                $_SESSION["ITEMS_PROC_DIALOG"] = Spell::makeItemProcDialogLayout($item);
                break;
            case "Heal":
                $heal = $sessionAttaquant->getHp() + 50;
                $sessionAttaquant->setHp($heal);
                $_SESSION["ITEMS_PROC_DIALOG"] = Spell::makeItemProcDialogLayout($item);
                break;
            case "Cool Boi":
                $heal = $sessionAttaquant->getHp() + 50;
                $dmg_boost = $sessionAttaquant->getBaseAtk() + 50 + $sessionAttaquant->getAtk();

                $sessionAttaquant->setHp($heal);
                $sessionAttaquant->setAtk($dmg_boost);

                $_SESSION["ITEMS_PROC_DIALOG"] = Spell::makeItemProcDialogLayout($item);
                break;
            case 'Fire damage':
                $dmg_boost = $sessionAttaquant->getBaseAtk() + 25 + $sessionAttaquant->getAtk();
                $sessionAttaquant->setAtk($dmg_boost);
                $_SESSION["ITEMS_PROC_DIALOG"] = Spell::makeItemProcDialogLayout($item);
                break;
            case 'Kungen > all':
                $dmg_boost = $sessionAttaquant->getBaseAtk() + 30 + $sessionAttaquant->getAtk();
                $health_boost = $sessionAttaquant->getHpBase() + 30 + $sessionAttaquant->getHp();

                $sessionAttaquant->setAtk($dmg_boost);
                $sessionAttaquant->setHp($health_boost);
                $_SESSION["ITEMS_PROC_DIALOG"] = Spell::makeItemProcDialogLayout($item);
                break;
            case '1/2 God':
                $dmg_boost_op = $sessionAttaquant->getAtk() + 30;
                $sessionAttaquant->setAtk($dmg_boost_op);
                $_SESSION["ITEMS_PROC_DIALOG"] = Spell::makeItemProcDialogLayout($item);
                break;
            case 'Godlike':
                $dmg_boost_op = $sessionAttaquant->getAtk() + 100;
                $sessionAttaquant->setAtk($dmg_boost_op);
                $_SESSION["ITEMS_PROC_DIALOG"] = Spell::makeItemProcDialogLayout($item);
                break;
            case 'Sco > Kungen':
                $dmg_boost_op = $sessionAttaquant->getAtk() + 50;
                $dmg_health_op = $sessionAttaquant->getHp() + 50;
                $sessionAttaquant->setAtk($dmg_boost_op);
                $sessionAttaquant->setHp($dmg_health_op);
                $_SESSION["ITEMS_PROC_DIALOG"] = Spell::makeItemProcDialogLayout($item);
                break;
            default:
                $_SESSION["ITEMS_PROC_DIALOG"] = "";
                break;
        }
    }

    static public function clearDialog($type){
        if($type === "ITEMS_PROC_DIALOG"){
            Utils::clearDialogProcItemChar();
        } elseif ($type = "SPELL_BOSS_CAST") {
            Utils::clearDialogBossSpell();
        }
    }



    //BECAREFULL already +50 each turn with the regen mana
    static public function bossSpell($sessionBoss, $sessionCharacter)
    {

        $SPELLS_KT = [
            0 => ["frost bolt", "../assets/boss_spell/frost_bolt.jpg", 250, 250],
            1 => ["frost cage", "../assets/boss_spell/frost_cage.jpg", 60, 200],
        ];

        $SPELLS_ARTHAS = [
            0 => ["infested", "../assets/boss_spell/infested.jpg", 500, 200],
            1 => ["blood pact", "../assets/boss_spell/blood_pact.jpg", 90, 150],
        ];

        $SPELLS_ILLIDAN = [
            0 => ["azzinoth flames", "../assets/boss_spell/azzinoth_flames.jpg", 150, 250],
            1 => ["fury", "../assets/boss_spell/fury.jpg", 40, 200],
        ];

        $rand = Utils::getRandom(0, 1);

        if($sessionBoss->getMana() >= Utils::mostExpensiveBossSpell()){
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


            }
        }
    }


    static public function charSpell($sessionUser, $sessionBoss)
    {
        if ($sessionUser->getHereo() === "asmongod") {

        } else if ($sessionUser->getHereo() === "leeroy") {
        }
    }



}