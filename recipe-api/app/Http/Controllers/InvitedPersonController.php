<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InvitedPerson;


class InvitedPersonController extends Controller
{


    public function store(Request $request){
        for($i = 0; $i < count($request->data); $i++){
           $invitedPersons[] = [
               "invitation_id" => $request->id,
               "user_id" => $request->data[$i]
               ];
       }

        return \Response::json(['data' => "invitations created"], 201);
    }

    public function update(Request $request, InvitedPerson $invitedPerson){
       $updatedInvite = $invitedPerson->update([
           'status' => $request->input('status')
        ]);

       return \Response::json(['data' => $updatedInvite], 200);


    }


}
