<?php

namespace App\Http\Controllers;

use App\Enums\NotificationType;
use App\Events\ChatUpdated;
use App\Http\Requests\Animator\UpdateChatRequest;
use App\Settings\GeneralSettings;

class SettingsController extends Controller
{
    public function update(UpdateChatRequest $request, GeneralSettings $settings)
    {
        $validated = $request->validated();

        if ($validated['chat_enabled'] === true && $settings->chat_enabled) {
            return back()->flash(NotificationType::ERROR, 'Le chat est déjà activé.');
        }

        if ($validated['chat_enabled'] === false && !$settings->chat_enabled) {
            return back()->flash(NotificationType::ERROR, 'Le chat est déjà désactivé.');
        }

        $settings->chat_enabled = $validated['chat_enabled'];
        $settings->save();

        broadcast(new ChatUpdated($settings->chat_enabled))->toOthers();

        if ($settings->chat_enabled) {
            return back()->flash(NotificationType::SUCCESS, 'Le chat a bien été activé.');
        }

        return back()->flash(NotificationType::SUCCESS, 'Le chat a bien été désactivé.')->with([
            'messages' => [],
        ]);
    }
}
