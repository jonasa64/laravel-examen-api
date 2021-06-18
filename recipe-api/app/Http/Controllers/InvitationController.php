<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInvitationRequest;
use App\Http\Requests\UpdateInvitationRequest;
use App\Models\Invitation;
use Illuminate\Support\Facades\DB;


class InvitationController extends Controller
{
    public function index()
    {
       $invitations = auth()->user()->invitations;

        $invitedTo = DB::table('invited_persons')->join('invitations', 'invitation_id', '=', 'invitations.id')->select('invited_persons.*', 'invitations.*')->where('invited_persons.user_id', '=', auth()->id())->get();
       return response()->json(['data' => $invitations, 'invitedTo' => $invitedTo], 200);
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

            return response()->json(["data" => auth()->user()->invitations], 201);
        }

        return response()->json(["data" => 'pleas log in'], 401);
    }


    public function show(Invitation $invitation)
    {
        $invitationWithPersons = $invitation->fresh('InvitedPersons');
        return response()->json(["data" => $invitationWithPersons] , 200);
    }


    public function update(UpdateInvitationRequest $request, Invitation $invitation)
    {
        if($invitation->isOwner() && $request->validated()){
                  $invitation->update([
                'title' => $request->title,
                'date' => $request->date,
                'location' => $request->location,
                'image' => $request->image,
                'description' => $request->description,
                'user_id' => auth()->user()->id
            ]);

            return response()->json(["data" => auth()->user()->invitations->fresh('InvitedPerson')], 200);
        }

        return  response()->json(["data" => "you can not do this"], 403);

    }


    public function destroy(Invitation $invitation)
    {

        if($invitation->isOwner()){
            $invitation->delete();
            return response()->json(['data' => null], 204);
        }



        return response()->json(["data" => "you can not do that"], 403);

    }
}
