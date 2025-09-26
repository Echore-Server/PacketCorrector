<?php

declare(strict_types=1);

namespace Echore\PacketCorrector;

use Echore\PacketCorrector\types\WrappedChunkCacheBlob;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\VarInt;
use pocketmine\network\mcpe\protocol\ClientboundPacket;
use pocketmine\network\mcpe\protocol\DataPacket;
use pocketmine\network\mcpe\protocol\PacketHandlerInterface;
use pocketmine\network\mcpe\protocol\ProtocolInfo;
use pocketmine\network\mcpe\protocol\serializer\CommonTypes;
use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class WrappedClientCacheMissResponsePacket extends DataPacket implements ClientboundPacket {
	public const NETWORK_ID = ProtocolInfo::CLIENT_CACHE_MISS_RESPONSE_PACKET;

	/** @var WrappedChunkCacheBlob[] */
	private array $blobs = [];


	/**
	 * @generate-create-func
	 * @param WrappedChunkCacheBlob[] $blobs
	 */
	public static function create(array $blobs): self {
		$result = new self;
		$result->blobs = $blobs;

		return $result;
	}

	public function handle(PacketHandlerInterface $handler): bool {
		return false;
	}

	protected function decodePayload(ByteBufferReader $in): void {
	}

	protected function encodePayload(ByteBufferWriter $out): void {
		VarInt::writeUnsignedInt($out, count($this->blobs));
		foreach ($this->blobs as $blob) {
			$out->writeByteArray($blob->getHashBinary());
			CommonTypes::putString($out, $blob->getPayload());
		}
	}
}
