<?php

namespace ProjectInfinity\PlayerFlow\listener;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;

use ProjectInfinity\PlayerFlow\PlayerFlow;

class PlayerListener implements Listener {

    private $plugin;

    public function __construct(PlayerFlow $plugin) {
        $this->plugin = $plugin;
    }

    public function onPlayerJoin(PlayerJoinEvent $event) {
        # Increment counter.
        $this->plugin->increment(true, $event->getPlayer()->getDisplayName());
        $event->setJoinMessage(null);
    }

    public function onPlayerQuit(PlayerQuitEvent $event) {
        # Increment counter.
        $this->plugin->increment(false, $event->getPlayer()->getDisplayName());
        # Cancel message.
        $event->setQuitMessage(null);
    }

}