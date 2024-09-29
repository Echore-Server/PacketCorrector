<?php

declare(strict_types=1);

namespace Echore\PacketCorrector;

use pocketmine\network\mcpe\protocol\PacketPool;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase {

	protected function onLoad(): void {
		PacketPool::getInstance()->registerPacket(new WrappedClientCacheMissResponsePacket());
		PacketPool::getInstance()->registerPacket(new WrappedClientCacheBlobStatusPacket());
		PacketPool::getInstance()->registerPacket(new WrappedLevelChunkPacket());
	}

}
