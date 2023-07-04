<?php

namespace App\Http\Controllers;

use App\Enums\InteractionStatus;
use App\Events\ChatUpdated;
use App\Events\InteractionEndedEvent;
use App\Models\Interaction;
use App\Models\Reward;
use App\Settings\GeneralSettings;
use Inertia\Inertia;

class AnimatorController extends Controller
{
    public function index(GeneralSettings $settings)
    {
        return Inertia::render('animator/index/page', [
            'chatEnabled' => $settings->chat_enabled,
            'interaction' => Interaction::pending()->with([
                'answers' => [
                    'auditor' => [
                        'user',
                    ],
                    'replyable',
                ],
                'winners' => [
                    'auditor' => [
                        'user',
                    ],
                ],
                'callToAction',
                'questionChoices',
            ])->first(),
            'rewards' => Reward::all(),
        ]);
    }

    public function endEmission(GeneralSettings $settings)
    {
        $settings->chat_enabled = false;
        $settings->save();

        ChatUpdated::dispatch($settings->chat_enabled);

        $currentInteraction = Interaction::pending()->first();
        $currentInteraction->update([
            'ended_at' => now(),
            'status' => InteractionStatus::STOPPED,
        ]);

        broadcast(new InteractionEndedEvent())->toOthers();

        return redirect()->back()->with([
            'chatEnabled' => $settings->chat_enabled,
            'interaction' => null,
        ]);
    }
}
