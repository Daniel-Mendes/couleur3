<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class AnswerData extends Data
{
    public function __construct(
        public int $id,
        public UserData $auditor,
        public InteractionData $interaction
    ) {
    }
}
