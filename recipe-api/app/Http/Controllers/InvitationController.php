<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInvitationRequest;
use App\Http\Requests\UpdateInvitationRequest;
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
                'description' => $request->description,
                'user_id' => auth()->user()->id
            ]);

            if($request->has('image')){
                $invitation->image = $request->input('image');
            } else {
                $invitation->image = 'https://firebasestorage.googleapis.com/v0/b/recipe-images-9a9cc.appspot.com/o/no-image.jpg?alt=media&token=c23fdbfa-0680-4125-bfe6-d41d5290ce62';
            }

            $invitation->save();

            return \Response::json(["data" => $invitation], 201);
        }

        return \Response::json(["data" => 'pleas log in'], 401);

    }


    public function show(Invitation $invitation)
    {
        $invitationWithPersons = $invitation->fresh('InvitedPerson');

        return \Response::json(["data" => $invitationWithPersons] , 200);
    }


    public function update(UpdateInvitationRequest $request, Invitation $invitation)
    {
        if($invitation->isOwner() && $request->validated()){
            $updatedInvitation = $invitation->update([
                'title' => $request->title,
                'date' => $request->date,
                'location' => $request->location,
                'user_id' => auth()->user()->id
            ]);

            if($request->has('image')){
                $invitation->image = $request->input('image');
                $invitation->save();

            }

            return \Response::json(["data" => $updatedInvitation], 200);
        }

        return \Response::json(["data" => "you can not do this"], 403);

    }


    public function destroy(Request $request)
    {
        $invitation = Invitation::where('id', '=', $request->input('id'))->firstOrFail();

        if($invitation->isOwner()){
            $invitation->delete();
            return \Response::json(['data' => null], 200);
        }



        return \Response::json(["data" => "you can not do that"], 403);

    }
}
