<?php

namespace App\Http\Controllers;

use App\Models\Interaction;
use App\Settings\GeneralSettings;
use Inertia\Inertia;
use Inertia\Response;

class AuditorController extends Controller
{
    public function index(GeneralSettings $settings): Response
    {
        return Inertia::render('auditor/index/page', [
            'chatEnabled' => $settings->chat_enabled,
            'interaction' => Interaction::active()->with([
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
            ])->first(),
        ]);
    }
}
