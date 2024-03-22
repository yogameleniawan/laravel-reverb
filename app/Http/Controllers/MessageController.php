<?php

namespace App\Http\Controllers;

use App\Events\SendMessageEvent;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        return view('message');
    }

    public function sendMessage(Request $request)
    {
        $message = $request->message;

        event(new SendMessageEvent(
            message: $message
        ));

        return response()->json(['message' => 'Message has been send'], 200);
    }
}
