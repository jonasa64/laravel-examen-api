<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInvitationRequest;
use App\Models\Invitation;
use Illuminate\Http\Request;


class InvitationController extends Controller
{
    public function index()
    {
       $invitations = auth()->user()->invitations;

       return \Response::json(['data' => $invitations], 200);
    }

    public function store(StoreInvitationRequest $request)
    {

        if(auth()->user() && $request->validated()){
            $invitation = Invitation::create([
                'title' => $request->title,
                'date' => $request->date,
                'location' => $request->location,
                'user_id' => auth()->user()->id
            ]);

            if($request->hasFile('image')){
                $invitation->addMediaFromRequest('image')->toMediaCollection('images');
                $invitation->image = $invitation->image();
            }

            return \Response::json(["data" => $invitation], 201);
        }

        return \Response::json(["data" => 'pleas log in'], 401);

    }


    public function show(Invitation $invitation)
    {
        $invitationWithPersons = $invitation::with('invitedPerson')->get();

        return \Response::json(["data" => $invitationWithPersons] , 200);
    }


    public function update(StoreInvitationRequest $request, Invitation $invitation)
    {
        if(auth()->user()->id == $invitation->user->id && $request->validated()){
            $updatedInvitation = $invitation->update([
                'title' => $request->title,
                'date' => $request->date,
                'location' => $request->location,
                'user_id' => auth()->user()->id
            ]);

            if($request->hasFile('image')){
                $updatedInvitation->clearMediaCollection('images');
                $updatedInvitation->addMediaFromRequest('image')->toMediaCollection('images');
                $updatedInvitation->image = $invitation->image();
            }

            return \Response::json(["data" => $updatedInvitation], 200);
        }

        return \Response::json(["data" => "you can not do this"], 401);

    }


    public function destroy(Request $request)
    {
        $invitation = Invitation::where('id', '=', $request->input('id'))->firstOrFail();

        if(auth()->user()->id == $invitation->user->id){
            $invitation->clearMediaCollection('images');
            $invitation->delete();
            return \Response::json(['data' => null], 200);
        }



        return \Response::json(["data" => "you can not do that"], 401);

    }
}
