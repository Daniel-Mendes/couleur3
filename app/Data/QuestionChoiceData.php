<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class QuestionChoiceData extends Data
{
    public function __construct(
        public int $id,
        public string $value,
        public bool $is_correct_answer,
        public ?InteractionData $interaction
    ) {
    }
}
