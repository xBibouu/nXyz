<?php

namespace xBibouXyz;


use pocketmine\plugin\PluginBase;
use xBibouXyz\Command\XyzCommand;

class Main extends PluginBase
{
    private static self $this;

    public function onEnable(): void
    {
        self::$this = $this;
        $this->saveDefaultConfig();

        $this->getServer()->getCommandMap()->register("", new XyzCommand());
    }

    public static function getInstance(): self
    {
        return self::$this;
    }
}