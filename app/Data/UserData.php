<?php

namespace App\Data;

use Carbon\Carbon;
use SensitiveParameter;
use Spatie\LaravelData\Attributes\WithTransformer;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Transformers\DateTimeInterfaceTransformer;

class UserData extends Data
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        #[WithTransformer(DateTimeInterfaceTransformer::class)]
        public Carbon $email_verified_at,
        #[SensitiveParameter]
        public ?string $password,
    ) {
    }
}
