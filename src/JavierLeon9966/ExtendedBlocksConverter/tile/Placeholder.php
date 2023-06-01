<?php

declare(strict_types = 1);

namespace JavierLeon9966\ExtendedBlocksConverter\tile;

use pocketmine\block\tile\Tile;
use pocketmine\block\{Block, VanillaBlocks};
use pocketmine\math\Vector3;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\world\format\io\GlobalBlockStateHandlers;
use pocketmine\world\World;

class Placeholder extends Tile{
	protected Block $block;

	public function __construct(World $world, Vector3 $pos){
		parent::__construct($world, $pos);
		$this->block = VanillaBlocks::INFO_UPDATE();
	}

	public function readSaveData(CompoundTag $nbt): void{
		$blockTag = $nbt->getCompoundTag('Block');
		if($blockTag !== null){
            $this->block = GlobalBlockStateHandlers::getDeserializer()->deserializeBlock(GlobalBlockStateHandlers::getUpgrader()->upgradeIntIdMeta($blockTag->getShort('id'), $blockTag->getByte('meta')));
		}
	}

	protected function writeSaveData(CompoundTag $nbt): void{
		// NOOP
	}

	public function getExtendedBlock(): Block{
		return clone $this->block;
	}
}