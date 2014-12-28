<?php

namespace ProjectInfinity\PlayerFlow\listener;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerKickEvent;
use pocketmine\event\player\PlayerQuitEvent;
use ProjectInfinity\PlayerFlow\PlayerFlow;

class PlayerListener implements Listener {

    private $plugin;

    public function __construct(PlayerFlow $plugin) {
        $this->plugin = $plugin;
    }

    public function onPlayerJoin(PlayerJoinEvent $event) {

    }

    public function onPlayerQuit(PlayerQuitEvent $event) {

    }

    public function onPlayerKick(PlayerKickEvent $event) {

    }

}