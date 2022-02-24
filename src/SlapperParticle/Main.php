<?php

namespace SlapperParticle;

use pocketmine\plugin\PluginBase;
use pocketmine\scheduler\Task;
use pocketmine\world\particle\{DustParticle, CriticalParticle};
use pocketmine\math\Vector3;
use slapper\entities\SlapperHuman;

class Main extends PluginBase{
    
    public function onEnable(): void{
        $this->getScheduler()->scheduleRepeatingTask(new Effect($this), 2);
        $this->getLogger()->info("[SlapperParticle] • plugin enable...");
    }
}

class Effect extends Task{
    
    private int $r = 0;
    private Main $main;
    
    public function __construct(Main $main){
        $this->main = $main;
    }
    
    public function onRun(): void{
        if($this->r < 0){
            $this->r++;
            return;
        }
        foreach($this->main->getServer()->getWorldManager()->getWorlds() as $world){
            foreach($world->getEntities() as $entity){
                if($entity instanceof SlapperHuman){
                    $x = $entity->getLocation()->getX();
                    $y = $entity->getLocation()->getY();
                    $z = $entity->getLocation()->getZ();
                    $worlds = $entity->getWorld();
                    $hypo = 0.8;
                    $a = cos(deg2rad($this->r/0.09))* $hypo;
                    $b = sin(deg2rad($this->r/0.09))* $hypo;
                    $time = (int) (microtime(true) - $this->main->getServer()->getStartTime());
                    $seconds = floor($time % 20);
                    $up = $seconds/5;
                    $pos1 = new Vector3($x - $a, $y + $up, $z - $b);
                    $pos2 = new Vector3($x - $b, $y + $up, $z - $a);
                    //for developers, Color code r = 255, g = 255, b = 255, You can change the color using the code. rgb
                    $effect1 = new DustParticle(new \pocketmine\color\Color(255,255,255));
                    $effect2 = new DustParticle(new \pocketmine\color\Color(255,255,255));
                    $worlds->addParticle($pos1, $effect1);
                    $worlds->addParticle($pos2, $effect2);
                    $this->r++;
                }
            }
        }
    }
}
