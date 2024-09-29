<?php

declare(strict_types=1);

namespace Echore\PacketCorrector;

use pocketmine\network\mcpe\protocol\DataPacket;
use pocketmine\network\mcpe\protocol\PacketHandlerInterface;
use pocketmine\network\mcpe\protocol\ProtocolInfo;
use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;
use pocketmine\network\mcpe\protocol\ServerboundPacket;

class WrappedClientCacheBlobStatusPacket extends DataPacket implements ServerboundPacket {
	public const NETWORK_ID = ProtocolInfo::CLIENT_CACHE_BLOB_STATUS_PACKET;

	/** @var string[] xxHash64 subchunk data hashes */
	private array $hitHashes = [];

	/** @var string[] xxHash64 subchunk data hashes */
	private array $missHashes = [];

	/**
	 * @generate-create-func
	 * @param int[] $hitHashes
	 * @param int[] $missHashes
	 */
	public static function create(array $hitHashes, array $missHashes): self {
		$result = new self;
		$result->hitHashes = $hitHashes;
		$result->missHashes = $missHashes;

		return $result;
	}

	/**
	 * @return int[]
	 */
	public function getHitHashes(): array {
		return $this->hitHashes;
	}

	/**
	 * @return int[]
	 */
	public function getMissHashes(): array {
		return $this->missHashes;
	}

	public function handle(PacketHandlerInterface $handler): bool {
		return false;
	}

	protected function decodePayload(PacketSerializer $in): void {
		$missCount = $in->getUnsignedVarInt();
		$hitCount = $in->getUnsignedVarInt();
		for ($i = 0; $i < $missCount; ++$i) {
			$this->missHashes[] = $in->get(8);
		}
		for ($i = 0; $i < $hitCount; ++$i) {
			$this->hitHashes[] = $in->get(8);
		}
	}

	protected function encodePayload(PacketSerializer $out): void {
	}
}
