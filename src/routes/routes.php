<?php

Route::middleware(['api', 'auth:sanctum'])
    ->prefix('api/ui')
        ->as('ui.')
        ->group(function() {
            Route::get('/retrieve/{resource}', [\SmartContact\UiMaker\app\Http\Controllers\Api\UiMakerController::class, 'retrieveUi'])->name('retrieve-ui');
        });