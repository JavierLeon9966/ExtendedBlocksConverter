<?php

declare(strict_types = 1);

namespace JavierLeon9966\ExtendedBlocksConverter;

use JavierLeon9966\ExtendedBlocksConverter\tile\Placeholder;

use pocketmine\block\tile\TileFactory;
use pocketmine\event\Listener;
use pocketmine\event\world\ChunkLoadEvent;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase implements Listener{

	protected function onLoad(): void{
		TileFactory::getInstance()->register(Placeholder::class);
	}

	protected function onEnable(): void{
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}

	/**
	 * @priority MONITOR
	 */
	public function onChunkLoad(ChunkLoadEvent $event): void{
		$world = $event->getWorld();
		foreach($event->getChunk()->getTiles() as $tile){
			if(!$tile instanceof Placeholder){
				continue;
			}
			$pos = $tile->getPosition();
			$world->setBlockAt($pos->x, $pos->y, $pos->z, $tile->getExtendedBlock(), false);
			$tile->close();
		}
	}
}