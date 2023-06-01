<?php

namespace App\Http\Controllers\Auditor;

use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMessageRequest;
use App\Models\Message;
use App\Settings\GeneralSettings;
use DB;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(GeneralSettings $settings)
    {
        if (!$settings->is_chat_enabled) {
            return Inertia::render('Auditor/Dashboard', [
                'messages' => [],
            ]);
        }

        $lastMessages = Message::orderByDesc('messages.created_at')
            ->take(10)
            ->join('auditors', 'auditors.id', '=', 'messages.auditor_id')
            ->join('users', function ($join) {
                $join->on('users.roleable_type', '=', DB::raw('"App\\\Models\\\Auditor"'))
                    ->on('users.roleable_id', '=', 'auditors.id');
            })
            ->select('messages.*', 'users.name as user_name')
            ->get()
            ->toArray();

        return Inertia::render('Auditor/Dashboard', [
            'messages' => array_reverse($lastMessages),
        ]);
    }

    public function storeMessage(StoreMessageRequest $request)
    {
        $validated = $request->validated();

        $user = Auth::user();
        $auditor = $user->roleable;

        $message = $auditor->messages()->create([
            'content' => $validated['message'],
        ])->toArray();

        $message['user_name'] = $user->name;

        broadcast(new MessageSent($message))->toOthers();

        return back()->with('status', 'Message sent!');
    }
}
