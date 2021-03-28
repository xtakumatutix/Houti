<?php

namespace xtakumatutix\houti;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\Player;

class Main extends PluginBase implements Listener
{
    public function onEnable()
    {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool
    {
        if ($sender instanceof Player) {
            $name = $sender->getName();
            if ($this->houti[$name] === false) {
                $this->houti[$name] = true;
                $this->getServer()->broadcastMessage('§b' . $name . 'さんが放置をはじめました');
                $sender->setImmobile(true);
                $sender->sendMessage('§bⓘ 放置中は動けません！');
            } else {
                $this->houti[$name] = false;
                $this->getServer()->broadcastMessage('§b' . $name . 'さんが放置をやめました');
                $sender->setImmobile(false);
            }
            return true;
        }
    }

    public function onjoin(PlayerJoinEvent $event)
    {
        $event->getPlayer()->setImmobile(false);
        $this->houti[$event->getPlayer()->getName()] = false;
    }
}