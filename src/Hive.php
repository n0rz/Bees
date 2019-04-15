<?php

namespace Bees;

use Bees\Bee as Bee;

class Hive
{
    private $hive = [];
    private $deadBeeKeys = [];
    private $gameOver = false;

    /**
     * Hive constructor.
     */
    public function __construct() {
        $this->generateBees();
    }

    /**
     * Generates queen, worker & drone bees by placing them in the hive array
     */
    private function generateBees() {
        array_push($this->hive, new Bee(Bee::$queenBeeType));

        for ($i=0; $i<5; $i++) {
            array_push($this->hive, new Bee(Bee::$workerBeeType));
        }

        for ($i=0; $i<8; $i++) {
            array_push($this->hive, new Bee(Bee::$droneBeeType));
        }
    }

    /**
     * Gets a random alive bee (key) from the hive array
     * If bee is killed, places it's hive key into the deadBeKeys array
     * If queen is killed, flag game over
     */
    public function shoot() {
        $beeKey = $this->getRandomAliveBeeKey();
        $bee = $this->hive[$beeKey];
        $bee->shoot();

        if (!$bee->isAlive()) array_push($this->deadBeeKeys, $beeKey);

        if ((($bee->getBeeType() == Bee::$queenBeeType) && !$bee->isAlive())) {
            $this->killAllBees();
            $this->gameOver = true;
        }
    }

    /**
     * Sets the HP for all bees to 0 and alive to false
     */
    private function killAllBees() {
        foreach ($this->hive as &$bee) {
            $bee->killBee();
        }
    }

    /**
     * Tries random bees from the hive until a live one is found, then returns it's key
     * @return int
     */
    public function getRandomAliveBeeKey() : int {
        do {
            $beeKey = array_rand($this->hive);
        } while (in_array($beeKey, $this->deadBeeKeys));

        return $beeKey;
    }

    /**
     * @return array
     */
    public function getBees() {
        return $this->hive;
    }

    /**
     * @return bool
     */
    public function isGameOver() {
        return $this->gameOver;
    }

    /**
     * Generates html for frontend
     */
    public function displayHive() {
        $queenBeeOkImgTag = '<img src="./img/queen-bee-ok.jpg"/> ';
        $queenBeeDeadImgTag = '<img src="./img/queen-bee-dead.jpg"/> ';
        $workerBeeOkImgTag = '<img src="./img/worker-bee-ok.jpg"/> ';
        $workerBeeDeadImgTag = '<img src="./img/worker-bee-dead.jpg"/> ';
        $droneBeeOkImgTag = '<img src="./img/drone-bee-ok.png"/> ';
        $droneBeeDeadImgTag = '<img src="./img/drone-bee-dead.png"/> ';

        $currBeeType = Bee::$queenBeeType;
        foreach ($this->hive as $bee) {
            //Places each bee type in 1 row
            if ($bee->getBeeType() != $currBeeType) {
                $currBeeType = $bee->getBeeType();
                echo "<br /><br />";
            }

            echo '<div style="display: inline-block; border: 1px solid black;">';

            echo '<div style="display: block;">';
            echo $bee->getHp().' HP';
            echo '</div>';

            switch ($bee->getBeeType()) {
                case Bee::$queenBeeType:
                    echo $bee->isAlive() ? $queenBeeOkImgTag : $queenBeeDeadImgTag;
                    break;
                case Bee::$workerBeeType:
                    echo $bee->isAlive() ? $workerBeeOkImgTag : $workerBeeDeadImgTag;
                    break;
                case Bee::$droneBeeType:
                    echo $bee->isAlive() ? $droneBeeOkImgTag : $droneBeeDeadImgTag;
            }
            echo "</div>";
        }
    }
}