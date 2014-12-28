<?php

namespace ProjectInfinity\PlayerFlow\task;

use pocketmine\scheduler\PluginTask;
use pocketmine\utils\TextFormat;
use ProjectInfinity\PlayerFlow\PlayerFlow;

class FlowTask extends PluginTask {

    private $plugin;

    public function __construct(PlayerFlow $plugin) {
        $this->plugin = $plugin;
    }

    public function onRun($currentTick) {

        $number = $this->plugin->interval / 60;

        $leftCount = count($this->plugin->getLeft());

        $msg = TextFormat::GOLD."In the last ".($number >= 1 ? $number." minute". ($number > 1 ? "s" : "") : $this->plugin->interval." second".($this->plugin->interval > 1) ? "s": ""). $leftCount. " player". ($leftCount > 1 ? "s" : "") ."left the server.";
        if($this->plugin->showPlayers) {
            # TODO: Show players.
        }

        $this->plugin->getServer()->broadcastMessage($msg);

        $this->plugin->getLeft();

        $this->plugin->reset();
    }
}