<?php

namespace ProjectInfinity\PlayerFlow\task;

use pocketmine\scheduler\PluginTask;
use pocketmine\utils\TextFormat;
use ProjectInfinity\PlayerFlow\PlayerFlow;

class FlowTask extends PluginTask {

    private $plugin;

    public function __construct(PlayerFlow $plugin) {
        parent::__construct($plugin);
        $this->plugin = $plugin;
    }

    public function onRun($currentTick) {

        $leftCount = count($this->plugin->getLeft());
        $joinedCount = count($this->plugin->getJoined());

        if($leftCount === 0 and $joinedCount === 0) {
            # Return, there's no point in saying that nobody joined or left the server.
            return;
        }

        $arr = explode(":",gmdate("i:s", $this->plugin->interval));
        # intval to remove leading zeros.
        $arr[0] = intval($arr[0]);
        $arr[1] = intval($arr[1]);

        # Joined the server.
        if($joinedCount) {
            $msg = TextFormat::GOLD."In the last ". TextFormat::GREEN . $arr[0] ." minute". ($arr[0] === 1 ? "" : "s") . TextFormat::GOLD . " and ". TextFormat::GREEN. $arr[1] ." second". ($arr[1] === 1 ? " " : "s ") .$joinedCount. " player". ($joinedCount === 1 ? "" : "s") . TextFormat::GOLD ." joined the server.";
            $this->plugin->getServer()->broadcastMessage($msg);
            # Show players if enabled.
            if($this->plugin->showPlayers) {
                $list = TextFormat::YELLOW."Players: ";
                foreach($this->plugin->getJoined() as $player) {
                    $list .= TextFormat::GREEN.$player.TextFormat::YELLOW.", ";
                }
                $this->plugin->getServer()->broadcastMessage(substr($list, 0, strlen($list) - 2));
            }
        }

        # Left server.
        if($leftCount > 0) {
            $msg = TextFormat::GOLD."In the last ". TextFormat::RED . $arr[0] ." minute". ($arr[0] === 1 ? "" : "s") . TextFormat::GOLD . " and ". TextFormat::RED. $arr[1] ." second". ($arr[1] === 1 ? " " : "s ") .$leftCount. " player". ($leftCount === 1 ? "" : "s") . TextFormat::GOLD ." left the server.";
            $this->plugin->getServer()->broadcastMessage($msg);
            # Show players if enabled.
            if($this->plugin->showPlayers) {
                $list = TextFormat::YELLOW."Players: ";
                foreach($this->plugin->getJoined() as $player) {
                    $list .= TextFormat::GREEN.$player.TextFormat::YELLOW.", ";
                }
                $this->plugin->getServer()->broadcastMessage(substr($list, 0, strlen($list) - 2));
            }
        }

        # We're done with the arrays, reset them.
        $this->plugin->reset();
    }
}