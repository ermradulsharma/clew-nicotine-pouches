<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoDirectWebhookController;

Route::prefix('v1')->group(function () {
    Route::post('webhook/godirect-order-status', [GoDirectWebhookController::class, 'handle']);
});
