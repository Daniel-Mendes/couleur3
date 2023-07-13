<?php

test('models')
    ->expect('App\Models')
    ->toOnlyUse('Illuminate\Database');

test('controllers')
    ->expect('App\Http\Controllers')
    ->not->toUse('Illuminate\Http\Request');

test('globals')
    ->expect(['dd', 'dump'])
    ->not->toBeUsed();

test('facades')
    ->expect('Illuminate\Support\Facades')
    ->not->toBeUsed()
    ->ignoring('App\Providers');
