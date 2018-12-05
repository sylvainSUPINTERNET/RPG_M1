<?php
/**
 * Created by PhpStorm.
 * User: sylvainjoly
 * Date: 04/12/2018
 * Time: 12:17
 */

require_once 'ActionChar.php';
require_once __DIR__.'/Interfaces/IDialog.php';
require_once __DIR__.'/Interfaces/ICharacter.php';

class CharacterChar extends ActionChar implements ICharacter, IDialog
{

    protected $nickname;
    protected $hereo;
    protected $atk;
    protected $hp;
    protected $mana;
    protected $game_session;
    protected $hereo_pic_path;


    protected $save; // TODO serialize / unserialize to keep the data

    protected $quotes = [
        "asmongod" => ["","",""], //1 => start / 2 => fight / 3 => end
        "leeroy" => ["","",""],


        //BOSS dialog
        "kelthuzad" => ["","",""],
        "arthas" => ["","",""],
        "illidan" => ["","",""]

    ];


    public function __construct($nickname, $hereo, $atk, $hp, $mana)

    {

            $this->setNickname($nickname);
            $this->setHereo($hereo);

            $this->setAtk($atk);
            $this->setHp($hp);
            $this->setMana($mana);

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
    public function setNewGameSession(CharacterChar $char){
        $_SESSION["character"] = $char;
        $_SESSION["naxx_access"] = false;
        $this->game_session = $_SESSION;
    }

    public function getGameSession(){
        return $this->game_session;
    }


    //ICharacter
    public function setHereoPic($hereo)
    {
        if($this->getHereo() === "asmongod"){
            $this->hereo_pic_path = "./assets/character/image/mdr.jpeg";
        } else if($this->getHereo() === "leeroy") {
            $this->hereo_pic_path = "./assets/character/image/leeroy-jenkins.jpg";
        }
    }

    public function getHereoPic(){
        return $this->hereo_pic_path;
    }


    //IDialog
    public function setQuotes($hereo)
    {
        if($hereo === "asmongod"){
            $this->quotes["asmongod"]=[
                "The fuck is that",
                "THATS NOT POSSIBLE",
                "Fuckin idiot, get out of here"
            ];
        } else if($hereo === "leeroy") {
            $this->quotes["leeroy"]=[
                "Ok let's do this",
                "LEEEROY JENKISSSS",
                "At last i have chicken"
            ];
        } else if($hereo === "Kel'Thuzad"){
            $this->quotes["Kel'Thuzad"]=[
                "Glory to the Lich King!",
                "Pray for mercy!",
                "I shall return..."
            ];
        } else if($hereo === "Illidan"){
            $this->quotes["Illidan"]=[
                "I feel only hatred.",
                "Let's move out.",
                "At last."
            ];
        } else if ($hereo === "Arthas"){
            $this->quotes["Arthas"]=[
                "Ho-ho. Are you nervous?",
                "Frostmourne yearns.",
                "Asmongold ... < McConnell"
            ];
        }
    }

    public function getQuotes(){
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



    //abstract ActionChar.php
    public function attack($sessionAttaquant, $sessionTarget) //pass session
    {
        $a_atk = $sessionAttaquant->getAtk();
        $t_hp = $sessionTarget->getHp();
        $sessionTarget->setHp($t_hp - $a_atk);
    }

    function specialAttack($attaquant, $target){ //pass session

    }


    //TODO implement system de sauvegarde
    public function saveGameSession(){
        $save = serialize($_SESSION);
        $this->save = $save;
    }
    public function setSave($saveSerialize){
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


    public static function serializeSession($session){
        return serialize($session);
    }


    public static function unseralizeSession($sessionSerialized){
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

}