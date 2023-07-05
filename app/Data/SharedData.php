<?php

namespace App\Data;

use Closure;
use Spatie\LaravelData\Data;

class SharedData extends Data
{
    public function __construct(
        public ?UserData $auth = null,
        public bool $chatEnabled = false,
        public ?InteractionData $interaction = null,
        public ?NotificationData $notification = null,
    ) {
        $this->shareNotification();
    }

    protected function shareNotification(): void
    {
        if (session('notification')) {
            $this->notification = new NotificationData(
                ...session('notification')
            );
        }
    }
}
