<?php

namespace App\Http\Controllers;

use App\Data\InteractionData;
use App\Data\RewardData;
use App\Enums\InteractionStatus;
use App\Events\ChatUpdated;
use App\Events\InteractionEndedEvent;
use App\Models\Interaction;
use App\Models\Reward;
use App\Settings\GeneralSettings;
use Inertia\Inertia;

class AnimatorController extends Controller
{
    public function index()
    {
        return Inertia::render('animator/index/page', [
            'interaction' => Interaction::pending()->first() ? InteractionData::from(Interaction::pending()->with([
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
            ])->first()) : null,
            'rewards' => RewardData::collection(Reward::all()),
        ]);
    }

    public function endEmission(GeneralSettings $settings)
    {
        $settings->chat_enabled = false;
        $settings->save();

        ChatUpdated::dispatch($settings->chat_enabled);

        $currentInteraction = Interaction::pending()->first();

        if ($currentInteraction) {
            $currentInteraction->update([
                'ended_at' => now(),
                'status' => InteractionStatus::STOPPED,
            ]);
        }

        broadcast(new InteractionEndedEvent())->toOthers();

        return redirect()->back();
    }
}
