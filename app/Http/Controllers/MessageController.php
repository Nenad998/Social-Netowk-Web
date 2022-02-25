<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessageRequest;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class MessageController extends Controller
{
    public function sendMessageView($userId)
    {
        $user = User::findOrFail($userId);

        return view('user.sendMessage', ['user'=> $user]);
    }

    public function sendMessage(MessageRequest $request)
    {
        $sender_id = Auth::user()->id;
        $receiver_id = $request->input('receiver_id');
        $content = $request->input('content');

        $message = new Message();
        $message->sender_id = $sender_id;
        $message->receiver_id = $receiver_id;
        $message->content = $content;
        $message->save();

        return Redirect::back()->with('sendMessage', 'Success sent message');

    }

    public function inbox()
    {
        //$messages = MessageRequest::with('users')->where('sender_id', '=', Auth::user()->id)->get();


            $messages1 = User::join('messages', 'users.id', '=', 'messages.receiver_id')
                ->select('users.id', 'users.name', 'messages.content')
                ->where('messages.sender_id', '=', Auth::user()->id)
                ->get();

            $messages2 = User::join('messages', 'users.id', '=', 'messages.sender_id')
                ->select('users.id', 'users.name', 'messages.content')
                ->where('messages.receiver_id', '=', Auth::user()->id)
                ->get();

        //$messages2 = MessageRequest::with('users2')->where('receiver_id', '=', Auth::user()->id)->get();

        return view('inbox.index', ['messages1'=> $messages1, 'messages2'=> $messages2]);
    }

    public function singleMessage($userId)
    {
        $messages = Message::with('users')->where('sender_id', '=', Auth::user()->id)->get();

        $singleMessages = User::join('messages', 'users.id', '=', 'messages.sender_id')
                             ->where('messages.sender_id', '=', $userId)
                             ->where('messages.receiver_id', '=', Auth::user()->id)
                             ->orWhere(function($query) use ($userId) {
                                $query->where('messages.sender_id', '=',Auth::user()->id)
                                    ->where('messages.receiver_id', '=', $userId);
                             })->orderBy('messages.created_at', 'asc')->get();

//        $messages = User::join('messages', 'users.id', '=', 'messages.sender_id')
//            ->where('messages.sender_id', '=', $userId)
//            ->where('messages.receiver_id', '=', Auth::user()->id)
//            ->orWhere(function($query) use ($userId) {
//                $query->where('messages.sender_id', '=',Auth::user()->id)
//                    ->where('messages.receiver_id', '=', $userId);
//            })->orderBy('messages.created_at', 'desc')->get();

        return view('inbox.singleMessage', ['messages'=> $messages, 'singleMessages'=> $singleMessages]);
    }
}
