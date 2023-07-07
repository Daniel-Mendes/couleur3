<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class AddressData extends Data
{
    public function __construct(
        public int $id,
        public string $street,
        public string $city,
        public string $zip_code,
        public string $country,
        public ?UserData $auditor,
    ) {
    }
}
