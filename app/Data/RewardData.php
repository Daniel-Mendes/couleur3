<?php

namespace App\Data;

use App\Models\Reward;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Lazy;

class RewardData extends Data
{
    public function __construct(
        public int $id,
        public string $name,
        public string $description,
        #[DataCollectionOf(InteractionData::class)]
        public DataCollection|Lazy $interactions
    ) {
    }

    public static function fromModel(Reward $reward)
    {
        return new self(
            id: $reward->id,
            name: $reward->name,
            description: $reward->description,
            interactions: Lazy::create(fn () => InteractionData::collection($reward->interactions)),
        );
    }
}
