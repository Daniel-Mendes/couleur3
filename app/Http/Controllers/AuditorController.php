<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class AuditorController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('auditor/index/page');
    }
}
