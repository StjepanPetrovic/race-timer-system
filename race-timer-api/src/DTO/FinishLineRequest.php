<?php
// src/Dto/FinishLineRequest.php
namespace App\DTO;

class FinishLineRequest
{
    public function __construct(
        public readonly int $start_number,
        public readonly int $race_id,
        public readonly \DateTimeImmutable $time
    ) {
    }
}
