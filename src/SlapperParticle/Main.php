<?php

namespace SlapperParticle;

use pocketmine\plugin\PluginBase;

class Main extends PluginBase{
    
    public function onEnable(): void{
        $this->getScheduler()->scheduleRepeatingTask(new Effect($this), 2);
        $this->getLogger()->info("[SlapperParticle] • plugin enable...");
    }
}
