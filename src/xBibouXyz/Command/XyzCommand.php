<?php
declare(strict_types=1);

namespace xBibouXyz\Command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\network\mcpe\protocol\GameRulesChangedPacket;
use pocketmine\network\mcpe\protocol\types\BoolGameRule;
use pocketmine\permission\DefaultPermissions;
use pocketmine\player\Player;
use xBibouXyz\Main;

class XyzCommand extends Command {

    public function __construct() {
        parent::__construct("xyz", "§aActiver / Désactiver les coordonnées", "/xyz on/off", ["coordinate"]);
        $this->setPermission(DefaultPermissions::ROOT_USER);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): void {
        if(!$sender instanceof Player) {
            $sender->sendMessage("Vous devez être un joueur pour use la commande Xyz");
            return;
        }

        if(count($args) < 1) {
            $sender->sendMessage("§c/xyz on/off");
            return;
        }

        switch($args[0]) {
            case "on":
                $pk = new GameRulesChangedPacket();
                $pk->gameRules = ["showcoordinates" => new BoolGameRule(true, false)];
                $sender->getNetworkSession()->sendDataPacket($pk);
                $sender->sendMessage(Main::getInstance()->getConfig()->get("msg-on"));
                break;
            case "off":
                $pk = new GameRulesChangedPacket();
                $pk->gameRules = ["showcoordinates" => new BoolGameRule(false, false)];
                $sender->getNetworkSession()->sendDataPacket($pk);
                $sender->sendMessage(Main::getInstance()->getConfig()->get("msg-off"));
                break;
            default:
                $sender->sendMessage("§c/xyz on/off");
        }
    }
}