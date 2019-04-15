<?php
namespace Bees;

class Bee {

    public static $queenBeeType = "QUEEN";
    public static $workerBeeType = "WORKER";
    public static $droneBeeType = "DRONE";
    private $alive = true;

    private $hp;
    private $beeType;
    private $queenHp = "100";
    private $workerHp = "75";
    private $droneHp = "50";
    private $queenDamage = '8';
    private $workerDamage = '10';
    private $droneDamage = '12';

    /**
     * Bee constructor.
     * @param string $beeType
     */
    public function __construct(string $beeType) {
        $this->beeType = $beeType;
        switch($beeType) {
            case self::$queenBeeType:
                $this->hp = $this->queenHp;
                break;
            case self::$workerBeeType:
                $this->hp = $this->workerHp;
                break;
            case self::$droneBeeType:
                $this->hp = $this->droneHp;
                break;
        }
    }

    /**
     * Deals damage to current bee
     */
    public function shoot() {
        switch($this->beeType) {
            case self::$queenBeeType:
                $this->damageHp($this->queenDamage);
                break;
            case self::$workerBeeType:
                $this->damageHp($this->workerDamage);
                break;
            case self::$droneBeeType:
                $this->damageHp($this->droneDamage);
                break;
        }
    }

    /**
     * Returns health of current bee
     * @return int
     */
    public function getHp() : int {
        return $this->hp;
    }

    /**
     * Sets the HP for current bee to 0 and alive to false
     */
    public function killBee() {
        $this->hp = 0;
        $this->alive = false;
    }

    /**
     * Assigns HP-damage points for current bee
     * @param int $damage
     */
    private function damageHp(int $damage) {
        if ($this->hp - $damage <= 0) {
            $this->killBee();
        } else {
            $this->hp -= $damage;
        }
    }

    /**
     * @return string
     */
    public function getBeeType() : string {
        return $this->beeType;
    }

    /**
     * @return bool
     */
    public function isAlive() : bool {
        return $this->alive;
    }
}