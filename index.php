<?php
require_once getCwd() . '/vendor/autoload.php';
use Bees\Hive;
session_start();

//Using Session as the game state
if (!isset($_SESSION['hive'])) {
    $hive = new Hive();
} elseif (isset($_POST['shot_fired'])) {
    $hive = $_SESSION['hive'];
    $hive->shoot();
}
$_SESSION['hive'] = $hive;
?>

<form action="" method="post">
    <input type="hidden" name="shot_fired"/>
    <button type="submit">
        Shoot!
    </button>
</form>

<?php

$hive->displayHive();

if ($hive->isGameOver()) {
    echo "<div><h3>Game Over!</h3></div>";
    unset($_SESSION['hive']);
}