<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

if(config('mary.components.toogle-sidebar')) {
    Route::middleware('web')->get('/mary/toogle-sidebar', function (Request $request) {
        if ($request->collapsed) {
            session(['mary-sidebar-collapsed' => $request->collapsed]);
        }
    });
}

if(config('mary.components.spotlight.class')) {
    Route::middleware('web')->get('/mary/spotlight', function (Request $request) {
        return app()->make(config('mary.components.spotlight.class'))->search($request);
    });
}

if(config('mary.components.upload')) {
    Route::middleware(['web', 'auth'])->post('/mary/upload', function (Request $request) {
        $disk = $request->disk ?? 'public';
        $folder = $request->folder ?? 'editor';

        $file = Storage::disk($disk)->put($folder, $request->file('file'), 'public');
        $url = Storage::disk($disk)->url($file);

        return ['location' => $url];
    });
}
