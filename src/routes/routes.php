<?php

Route::middleware(['api'])
    ->prefix('api/ui')
        ->as('ui.')
        ->group(function() {
            Route::get('/retrieve/{microservice}/{resource}', [\SmartContact\UiMaker\app\Http\Controllers\Api\UiMakerController::class, 'retrieveUi'])->name('retrieve-ui');
        });