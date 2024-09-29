<?php

declare(strict_types=1);

namespace Echore\PacketCorrector\types;

class WrappedChunkCacheBlob {

	public function __construct(
		private string $hashBinary,
		private string $payload
	) {

	}

	public function getHashBinary(): string {
		return $this->hashBinary;
	}

	/**
	 * @return string
	 */
	public function getPayload(): string {
		return $this->payload;
	}

}
