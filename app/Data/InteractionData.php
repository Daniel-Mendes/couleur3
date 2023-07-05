<?php

namespace App\Data;

use App\Enums\InteractionStatus;
use App\Enums\InteractionType;
use DateTime;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Attributes\DataCollectionOf;

class InteractionData extends Data
{
    public function __construct(
        public int $id,
        public string $title,
        public InteractionType $type,
        public ?CallToActionData $call_to_action,
        #[DataCollectionOf(QuestionChoiceData::class)]
        public DataCollection $question_choices,
        #[DataCollectionOf(AnswerData::class)]
        public DataCollection $answers,
        public UserData $animator,
        public ?RewardData $reward,
        public DateTime $ended_at,
        public ?int $winners_count,
        #[DataCollectionOf(UserData::class)]
        public DataCollection $winners,
        public InteractionStatus $status,
    ) {
    }
}
