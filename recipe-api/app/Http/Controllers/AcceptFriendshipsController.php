<?php

namespace App\Http\Controllers;


use App\Models\Fiendship;
use App\Models\User;

class AcceptFriendshipsController extends Controller
{

    public function index(){
      $friendships =  Fiendship::with('sender')->where([

            'recipient_id' => auth()->id()

        ])->get();

        return \Response::json(["data" => $friendships], 200);
    }

    public function store(User $sender){
        Fiendship::where([
            'sender_id'=> $sender->id,
            'recipient_id' => auth()->id()
        ])->update(['status' => 'accepted']);
    return \Response::json([ 'friendship_status' => 'accepted'], 200);

    }

    public function destroy(User $sender) {

        Fiendship::where([

            'sender_id' => $sender->id,
            'recipient_id' => auth()->id(),

        ])->update(['status' => 'denied']);

        return \Response::json([

            'friendship_status' => 'denied'

        ], 200);

    }
}
