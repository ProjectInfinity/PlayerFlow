<?php

namespace ProjectInfinity\PlayerFlow;

use pocketmine\plugin\PluginBase;

use ProjectInfinity\PlayerFlow\listener\PlayerListener;
use ProjectInfinity\PlayerFlow\task\FlowTask;

class PlayerFlow extends PluginBase {

    public $interval;
    public $showPlayers;

    private static $left;
    private static $joined;

    private $task;

    public function onEnable() {
        $this->saveDefaultConfig();
        $this->reloadConfig();

        # This is in seconds.
        $this->interval = $this->getConfig()->get("interval");
        # This will show or hide players from the broadcast.
        $this->showPlayers = $this->getConfig()->get("showPlayers");

        $this->getServer()->getPluginManager()->registerEvents(new PlayerListener($this), $this);

        # Start flow task.
        $this->task = $this->getServer()->getScheduler()->scheduleRepeatingTask(new FlowTask($this), $this->interval * 20)->getTaskId();
    }

    public function onDisable() {
        $this->getServer()->getScheduler()->cancelTask($this->task);
        PlayerFlow::$joined = null;
        PlayerFlow::$left = null;
    }

    public function getLeft() {
        return PlayerFlow::$left;
    }

    public function reset() {
        PlayerFlow::$left = null;
        PlayerFlow::$joined = null;

        PlayerFlow::$joined = [];
        PlayerFlow::$left = [];
    }

}