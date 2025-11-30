<?php

declare(strict_types=1);

namespace PocketFightBot;

use pocketmine\plugin\PluginBase;
use pocketmine\command\{Command, CommandSender};
use pocketmine\entity\EntityDataHelper;
use pocketmine\entity\EntityFactory;
use pocketmine\entity\Human;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\player\Player;
use pocketmine\world\World;

class Main extends PluginBase {

    public function onEnable(): void {
        $this->saveDefaultConfig();
        
        // Register the Entity for PM5
        EntityFactory::getInstance()->register(FightBot::class, function(World $world, CompoundTag $nbt): FightBot {
            return new FightBot(EntityDataHelper::parseLocation($nbt, $world), Human::parseSkinNBT($nbt), $nbt);
        }, ['FightBot', 'pocketfightbot:bot']);
        
        $this->getLogger()->info("§cPocketFightBot §aEnabled!");
    }

    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args): bool {
        if ($cmd->getName() === "fightbot") {
            if (!$sender instanceof Player) {
                $sender->sendMessage("§cUse this command in-game.");
                return false;
            }

            if (count($args) < 1) {
                $sender->sendMessage("§cUsage: /fightbot <name>");
                return false;
            }

            $name = implode(" ", $args);
            $location = $sender->getLocation();
            
            // Create NBT data
            $nbt = CompoundTag::create()
                ->setTag("Skin", $sender->getSkin()->getCompoundTag());
            
            // Create the bot using the factory
            $bot = new FightBot($location, $sender->getSkin(), $nbt);
            $bot->setNameTag($name);
            $bot->setNameTagAlwaysVisible(true);
            $bot->spawnToAll();

            // Inject config values
            $config = $this->getConfig();
            $bot->setAttributes(
                (float)$config->get("bot_speed"),
                (float)$config->get("bot_damage"),
                (float)$config->get("reach_distance")
            );

            $sender->sendMessage("§aSpawned FightBot: §f$name");
            return true;
        }
        return false;
    }
}
