<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Models\Fiendship;
use App\Models\User;

class FiendshipController extends Controller
{

    public function store(User $recipient)
    {
        if(auth()->id() == $recipient->id){
            return \Response::json(["data" => "can di that"], 400);
        }

        $friendship = Fiendship::firstOrCreate([
           'sender_id' => auth()->id(),
           'recipient_id' =>  $recipient->id
        ]);

        return \Response::json(["data" => $friendship->fresh()->status], 201);
    }

    public function destroy(User $user)
    {
        $friendship = Fiendship::scopeBetweenUsers(auth()->user(), $user )->first();

        if ($friendship->status === 'denied' && (int) $friendship->sender_id === auth()->id()) {

            return Response::json([

                'friendship_status' => 'denied'

            ]);

        }

        return Response::json([

            'friendship_status' => $friendship->delete() ? 'deleted' : ''

        ]);

    }
}
