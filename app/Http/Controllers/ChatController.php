<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\MessageSentEvent;
use App\Message;
use App\User;
use App\DetMessage;
use DB;

class ChatController extends Controller
{
    public function fetchMessages()
    {
        $messages = DB::table('det_messages')
                    ->join('messages', 'messages.id', '=', 'det_messages.message_id')
                    ->join('users', 'users.id', '=', 'messages.user_1')
                    ->join('users AS user1', 'user1.id', '=', 'messages.user_2')
                    ->select('users.*', 'messages.*', 'det_messages.*')
                    ->get();

        return response()->json($messages);
    }

    /**
     * Persist message to database
     *
     * @param  Request $request
     * @return Response
     */
    public function sendMessage(Request $request)
    {
        $user = User::find($request->get('user_id'));
        $message = $user->messages()->create([
            'messages' => request()->message,
            'message_id' => request()->message_id
        ]);

        event(new MessageSentEvent($user, $request->message));
    }
}
