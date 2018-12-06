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

    //for calcul stats via items
    protected $base_atk;
    protected $base_hp;
    protected $base_mana;

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


    public function __construct($nickname, $hereo, $atk, $hp, $mana)

    {

        $this->setNickname($nickname);
        $this->setHereo($hereo);

        $this->setAtk($atk);
        $this->setHp($hp);
        $this->setMana($mana);

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
                "The fuck is that",
                "THATS NOT POSSIBLE",
                "Fuckin idiot, get out of here"
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
                "I shall return..."
            ];
        } else if ($hereo === "Illidan") {
            $this->quotes["Illidan"] = [
                "I feel only hatred.",
                "Let's move out.",
                "At last."
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
        $this->mana += 50;
    }


    //abstract ActionChar.php
    public function attack($sessionAttaquant, $sessionTarget) //pass session
    {

        $a_atk = $sessionAttaquant->getAtk();
        $t_hp = $sessionTarget->getHp();
        $sessionTarget->setHp($t_hp - $a_atk);


        //if user has items
        if (isset($_SESSION['inventory']) && sizeof($_SESSION['inventory']) > 0) {
            $this->specialAttack($sessionAttaquant, $sessionTarget); //apply random buff from his items list
        }


        $this->regenMana();


        //TODO -> creer 2 3 spells pour les boss (cooldown + mana points)
        //TODO -> creer 2 3 spells pour le perso (cooldown + mana points)
        //TODO -> corriger la regen mana + coup des spells non respecté par les boss
        //TODO -> corriger le bug si vie negative on arrete le jeu on laisse pas un tour supp pour rien
        // TODO -> pour le mana faire un calcul et faire le if sur ce calcul genre pas faire < 1OO mais checke si le calcul du mana restant est bien > ou = 0
        //TODO -> clear TODO + var_dump

    }


    //call only if the character has items with damage buff
    function specialAttack($attaquant, $target)
    { //pass session
        $all_dialog = [];
        foreach ($_SESSION['inventory'] as $item) {
            array_push($all_dialog, $item->getItemBuffProcDialog());
        }
        $rand = Utils::getRandom(0, sizeof($all_dialog) - 1);

        Spell::makeProcEffect($all_dialog[$rand], $attaquant, $target);
    }


    //TODO implement system de sauvegarde
    public function saveGameSession()
    {
        $save = serialize($_SESSION);
        $this->save = $save;
    }

    public function setSave($saveSerialize)
    {
    }
    // todo

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

}