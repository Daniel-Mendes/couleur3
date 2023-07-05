<?php

namespace App\Data;

use App\Models\Address;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Lazy;

class AddressData extends Data
{
    public function __construct(
        public ?int $id,
        public string $street,
        public string $zip_code,
        public string $city,
        public string $country,
        public UserData|null|Lazy $auditor,
    ) {
    }

    public static function fromModel(Address $address)
    {
        return new self(
            id: $address->id,
            street: $address->street,
            zip_code: $address->zip_code,
            city: $address->city,
            country: $address->country,
            auditor: Lazy::create(fn () => UserData::from($address->auditor)),
        );
    }
}
