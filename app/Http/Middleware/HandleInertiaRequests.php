<?php

namespace App\Http\Middleware;

use App\Data\InteractionData;
use App\Data\SharedData;
use App\Data\UserData;
use App\Models\Interaction;
use App\Settings\GeneralSettings;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $state = new SharedData(
            auth: $request->user() ? UserData::from($request->user()) : null,
            chatEnabled: app(GeneralSettings::class)->chat_enabled,
            interaction: Interaction::active()->first() ? InteractionData::from(Interaction::active()->first()->with([
                'answers' => [
                    'auditor' => [
                        'user',
                        'address',
                        'winners',
                    ],
                    'replyable',
                ],
                'callToAction',
                'questionChoices',
            ])->first()) : null,
        );

        return array_merge(
            parent::share($request),
            $state->toArray()
        );
    }
}
