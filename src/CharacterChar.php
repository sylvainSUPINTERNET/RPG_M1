<?php
/**
 * Created by PhpStorm.
 * User: sylvainjoly
 * Date: 04/12/2018
 * Time: 12:17
 */

require_once 'ActionChar.php';
require_once __DIR__ . '/Interfaces/IDialog.php';
require_once __DIR__ . '/Interfaces/ICharacter.php';

class CharacterChar extends ActionChar implements ICharacter, IDialog
{

    protected $nickname;
    protected $hereo;
    protected $atk;
    protected $hp;
    protected $mana;
    protected $regen_mana_ratio = 50; // +50 each turns

    //for calcul stats via items
    protected $base_atk;
    protected $base_hp;
    protected $base_mana;

    protected $gold;

    protected $game_session;
    protected $hereo_pic_path;

    protected $buffActivated = false; // will apply on portal fight scene stats from inventory then lock to avoid bug
    // if win, is reset to false to update new items collected stat

    protected $save;

    protected $quotes = [
        "asmongod" => ["", "", ""], //1 => start / 2 => fight / 3 => end
        "leeroy" => ["", "", ""],


        //BOSS dialog
        "kelthuzad" => ["", "", ""],
        "arthas" => ["", "", ""],
        "illidan" => ["", "", ""]

    ];


    public function __construct($nickname, $hereo, $atk, $hp, $mana, $gold)

    {

        $this->setNickname($nickname);
        $this->setHereo($hereo);

        $this->setAtk($atk);
        $this->setHp($hp);
        $this->setMana($mana);
        $this->setGold($gold);

        $this->setBaseAtk($atk);
        $this->setBaseHp($hp);
        $this->setBaseMana($mana);

        //Init profile pic path
        $this->setHereoPic($this->getHereo());

        //init dialog
        $this->setQuotes($this->getHereo());


    }

    /**
     * @return mixed
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * @param mixed $nickname
     */
    public function setNickname($nickname)
    {
        $this->nickname = $nickname;
    }

    /**
     * @return mixed
     */
    public function getHereo()
    {
        return $this->hereo;
    }

    /**
     * @param mixed $hereo
     */
    public function setHereo($hereo)
    {
        $this->hereo = $hereo;
    }


    /**
     * Game state
     */
    public function setNewGameSession(CharacterChar $char)
    {
        $_SESSION["character"] = $char;
        $_SESSION["naxx_access"] = false;
        $this->game_session = $_SESSION;
    }

    public function getGameSession()
    {
        return $this->game_session;
    }


    //ICharacter
    public function setHereoPic($hereo)
    {
        if ($this->getHereo() === "asmongod") {
            $this->hereo_pic_path = "./assets/character/image/mdr.jpeg";
        } else if ($this->getHereo() === "leeroy") {
            $this->hereo_pic_path = "./assets/character/image/leeroy-jenkins.jpg";
        }
    }

    public function getHereoPic()
    {
        return $this->hereo_pic_path;
    }


    //IDialog
    public function setQuotes($hereo)
    {
        if ($hereo === "asmongod") {
            $this->quotes["asmongod"] = [
                "Dofus vanilla > All",
                "JS > Php",
                "gg wp ez"
            ];
        } else if ($hereo === "leeroy") {
            $this->quotes["leeroy"] = [
                "Ok let's do this",
                "LEEEROY JENKISSSS",
                "At last i have chicken"
            ];
        } else if ($hereo === "Kel'Thuzad") {
            $this->quotes["Kel'Thuzad"] = [
                "Glory to the Lich King!",
                "Pray for mercy!",
                "Asmon the casu..."
            ];
        } else if ($hereo === "Illidan") {
            $this->quotes["Illidan"] = [
                "I feel only hatred.",
                "Let's move out.",
                "yasuo = -3 lp"
            ];
        } else if ($hereo === "Arthas") {
            $this->quotes["Arthas"] = [
                "Ho-ho. Are you nervous?",
                "Frostmourne yearns.",
                "Asmongold ... < McConnell"
            ];
        }
    }

    public function getQuotes()
    {
        return $this->quotes;
    }


    /**
     * @return mixed
     */
    public function getAtk()
    {
        return $this->atk;
    }

    public function setAtk($atk)
    {
        $this->atk = $atk;
    }


    public function regenMana()
    {
        $ratio = $this->getRegenManaRatio();
        $this->mana += $ratio;
    }


    //abstract ActionChar.php
    public function attack($sessionAttaquant, $sessionTarget, $typeAttaquant) //pass session
    {

        $a_atk = $sessionAttaquant->getAtk();
        $t_hp = $sessionTarget->getHp();
        $sessionTarget->setHp($t_hp - $a_atk);


        //if user has items
        if (isset($_SESSION['inventory']) && sizeof($_SESSION['inventory']) > 0 && $typeAttaquant !== "boss") {
            $this->specialAttack($sessionAttaquant, $sessionTarget); //apply random buff from his items list
        }


        $this->regenMana();
    }


    //call only if the character has items with damage buff
    function specialAttack($attaquant, $target)
    { //pass session
        $stat_special = [];
        foreach ($_SESSION['inventory'] as $item) {
            array_push($stat_special, $item->getStatSpecial());
        }
        $rand = Utils::getRandom(0, sizeof($stat_special) - 1);

        Spell::makeProcEffect($stat_special[$rand], $attaquant, $target, $item);
    }


    function skillAttack($attaquant, $target, $skill_effect, $manaCost)
    {

        switch ($skill_effect) {
            case 'QUICK_HEAL':
                $current_hp = $attaquant->getHp();
                $current_mana = $attaquant->getMana();

                $heal_amount = 150;
                $attaquant->setHp($current_hp + $heal_amount);

                $attaquant->setMana($current_mana - $manaCost);
                break;
            case 'BONUS_ATK':
                $current_atk = $attaquant->getAtk();
                $current_mana = $attaquant->getMana();

                $atk_bonus = 10;
                $attaquant->setAtk($current_atk + $atk_bonus);

                $attaquant->setMana($current_mana - $manaCost);

                break;
            case 'ULTIMATE':
                $dmg_bonus = 250;
                $hp_bonus = 250;
                $current_hp = $attaquant->getHp();
                $current_atk = $attaquant->getAtk();
                $current_mana = $attaquant->getMana();

                $target_current_hp = $target->getHp();


                $attaquant->setHp($current_hp + $hp_bonus);
                $attaquant->setAtk($current_atk + $dmg_bonus);

                $target->setHp($target_current_hp - 400);

                $attaquant->setMana($current_mana - $manaCost);
                break;
            default:
                break;
        }


        $this->regenMana();
    }


    public function saveGameSession()
    {
        $save = serialize($_SESSION);
        $this->save = $save;
    }

    public function setSave($saveSerialize)
    {
    }

    /**
     * @return mixed
     */
    public function getHp()
    {
        return $this->hp;
    }

    /**
     * @param mixed $hp
     */
    public function setHp($hp)
    {
        $this->hp = $hp;
    }


    public static function serializeSession($session)
    {
        return serialize($session);
    }


    public static function unseralizeSession($sessionSerialized)
    {
        return unserialize($sessionSerialized);
    }


    /**
     * @return mixed
     */
    public function getMana()
    {
        return $this->mana;
    }

    /**
     * @param mixed $mana
     */
    public function setMana($mana)
    {
        $this->mana = $mana;
    }


    public function setBuffFromItems()
    {
        //ici le bug il additionne a chaque tour de boucle alors qu'il devrait pas

        if (isset($_SESSION["inventory"]) && sizeof($_SESSION["inventory"]) > 0) {

            $atk_total_items = 0;
            $health_total_items = 0;
            $mana_total_items = 0;

            foreach ($_SESSION['inventory'] as $item) {
                if ($item->getStatAtk()) {
                    $atk_total_items += $item->getStatAtk();
                }
                if ($item->getStatHealth()) {
                    $health_total_items += $item->getStatHealth();
                }
                if ($item->getStatMana()) {
                    $mana_total_items += $item->getStatMana();
                }
            }

            $_SESSION["character"]->setAtk($_SESSION["character"]->getBaseAtk() + $atk_total_items);
            $_SESSION["character"]->setHp($_SESSION["character"]->getBaseHp() + $health_total_items);
            $_SESSION["character"]->setMana($_SESSION["character"]->getBaseMana() + $mana_total_items);

            $_SESSION["character"]->setBuffActivated(true);
        }
    }

    public function isBuffActivated()
    {
        return $this->buffActivated;
    }

    public function setBuffActivated($boolean)
    {
        return $this->buffActivated = $boolean;
    }

    /**
     * @return mixed
     */
    public function getBaseAtk()
    {
        return $this->base_atk;
    }

    /**
     * @param mixed $base_atk
     */
    public function setBaseAtk($base_atk)
    {
        $this->base_atk = $base_atk;
    }

    /**
     * @return mixed
     */
    public function getBaseHp()
    {
        return $this->base_hp;
    }

    /**
     * @param mixed $base_hp
     */
    public function setBaseHp($base_hp)
    {
        $this->base_hp = $base_hp;
    }

    /**
     * @return mixed
     */
    public function getBaseMana()
    {
        return $this->base_mana;
    }

    /**
     * @param mixed $base_mana
     */
    public function setBaseMana($base_mana)
    {
        $this->base_mana = $base_mana;
    }

    /**
     * @return int
     */
    public function getRegenManaRatio()
    {
        return $this->regen_mana_ratio;
    }

    /**
     * @param int $regen_mana_ratio
     */
    public function setRegenManaRatio($regen_mana_ratio)
    {
        $this->regen_mana_ratio = $regen_mana_ratio;
    }

    /**
     * @return mixed
     */
    public function getGold()
    {
        return $this->gold;
    }

    /**
     * @param mixed $gold
     */
    public function setGold($gold)
    {
        $this->gold = $gold;
    }

    public function pay($item, $invArr){

        $duplicate = false;
        foreach($_SESSION['inventory'] as $inv_item){
            if($inv_item->getName() === $item->getName()){
                $duplicate = true;
                echo "<p class='alert alert-danger'>Sorry, you already have this item </p>";
                break;
            }
        }

        if(!$duplicate){
            $userGold = $_SESSION['character']->getGold();
            $item_price = $item->getGold();
            $diff = $userGold - $item_price;


            if($diff < 0){
                echo "<p class='alert alert-danger'>Not enough gold for this.</p>";
            } else {
                array_push($invArr,$item);
                $_SESSION['inventory'] = $invArr;
                $_SESSION['character']->setGold($diff);
            }

        }

    }

}