<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class CallToActionData extends Data
{
    public function __construct(
        public int $id,
        public string $link,
        public InteractionData $interaction
    ) {
    }
}
