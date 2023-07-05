<?php

namespace App\Http\Controllers;

use App\Enums\InteractionStatus;
use App\Enums\InteractionType;
use App\Events\InteractionCreated;
use App\Events\InteractionEndedEvent;
use App\Http\Requests\Interaction\StoreCallToActionRequest;
use App\Http\Requests\Interaction\StoreMCQRequest;
use App\Http\Requests\Interaction\StoreQuickClickRequest;
use App\Http\Requests\Interaction\StoreSurveyRequest;
use App\Http\Requests\Interaction\StoreTextRequest;
use App\Models\CallToAction;
use App\Models\Interaction;
use Auth;

class InteractionController extends Controller
{
    public function storeCTA(StoreCallToActionRequest $request)
    {
        $validated = $request->validated();

        $cta = CallToAction::create($validated);
        $interaction = new Interaction();
        /** @var \App\Models\User $user */
        $user = Auth::user();
        /** @var \App\Models\Animator $animator */
        $animator = $user->roleable;

        $interaction->title = $validated['title'];
        $interaction->type = InteractionType::CTA;
        $interaction->call_to_action_id = $cta->id;
        $interaction->animator_id = $animator->id;
        $interaction->ended_at = now()->addSeconds($validated['duration']);

        $interaction->save();

        $interaction->load('callToAction');

        broadcast(new InteractionCreated($interaction))->toOthers();

        return redirect()->back();
    }

    public function storeQuickClick(StoreQuickClickRequest $request)
    {
        $validated = $request->validated();

        $interaction = new Interaction();
        /** @var \App\Models\User $user */
        $user = Auth::user();
        /** @var \App\Models\Animator $animator */
        $animator = $user->roleable;

        $interaction->title = $validated['title'];
        $interaction->type = InteractionType::QUICK_CLICK;
        $interaction->animator_id = $animator->id;
        $interaction->ended_at = now()->addSeconds($validated['duration']);

        $interaction->save();

        broadcast(new InteractionCreated($interaction))->toOthers();

        return redirect()->back();
    }

    public function storeMCQ(StoreMCQRequest $request)
    {
        $validated = $request->validated();

        $interaction = new Interaction();
        /** @var \App\Models\User $user */
        $user = Auth::user();
        /** @var \App\Models\Animator $animator */
        $animator = $user->roleable;

        $interaction->title = $validated['title'];
        $interaction->type = InteractionType::MCQ;
        $interaction->animator_id = $animator->id;
        $interaction->ended_at = now()->addSeconds($validated['duration']);

        $interaction->save();

        for ($i = 0; $i < count($validated['question_choices']); $i++) {
            if ($validated['question_choices'][$i]['value']) {
                $interaction->questionChoices()->create($validated['question_choices'][$i]);
            }
        }

        $interaction->load('questionChoices');

        broadcast(new InteractionCreated($interaction))->toOthers();

        return redirect()->back();
    }

    public function storeText(StoreTextRequest $request)
    {
        $validated = $request->validated();

        $interaction = new Interaction();
        /** @var \App\Models\User $user */
        $user = Auth::user();
        /** @var \App\Models\Animator $animator */
        $animator = $user->roleable;

        $interaction->title = $validated['title'];
        $interaction->type = InteractionType::TEXT;
        $interaction->animator_id = $animator->id;
        $interaction->ended_at = now()->addSeconds($validated['duration']);

        $interaction->save();

        broadcast(new InteractionCreated($interaction))->toOthers();

        return redirect()->back();
    }

    public function storeSurvey(StoreSurveyRequest $request)
    {
        $validated = $request->validated();

        $interaction = new Interaction();
        /** @var \App\Models\User $user */
        $user = Auth::user();
        /** @var \App\Models\Animator $animator */
        $animator = $user->roleable;

        $interaction->title = $validated['title'];
        $interaction->type = InteractionType::SURVEY;
        $interaction->animator_id = $animator->id;
        $interaction->ended_at = now()->addSeconds($validated['duration']);

        $interaction->save();

        for ($i = 0; $i < count($validated['question_choices']); $i++) {
            if ($validated['question_choices'][$i]['value']) {
                $interaction->questionChoices()->create($validated['question_choices'][$i]);
            }
        }

        $interaction->load('questionChoices');

        broadcast(new InteractionCreated($interaction))->toOthers();

        return redirect()->back();
    }

    public function endInteraction(Interaction $interaction)
    {
        $interaction->update([
            'ended_at' => now(),
            'status' => InteractionStatus::STOPPED,
        ]);

        broadcast(new InteractionEndedEvent())->toOthers();

        return redirect()->back();
    }
}
