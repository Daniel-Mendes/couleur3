<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRewardRequest;
use App\Models\Reward;

class RewardController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRewardRequest $request)
    {
        $validated = $request->validated();
        $reward = Reward::create($validated);

        return response()->json($reward, 201);
    }
}
