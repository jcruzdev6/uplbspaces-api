<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\NotificationMailer;
use Log;

class MailerController extends Controller
{
    function sendContactUs(Request $request) {
        Log::debug('MailerController::sendContactUs');
            Mail::to('jane@ijuana.dev')->send(new NotificationMailer($request));
            return response()->json([
                'success' => true
            ], 200);
    }
}
