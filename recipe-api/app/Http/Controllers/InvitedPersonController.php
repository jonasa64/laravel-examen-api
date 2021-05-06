<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InvitedPerson;


class InvitedPersonController extends Controller
{


    public function store(Request $request){
       $invitedPerson = InvitedPerson::create([
            'invitation_id' => $request->input('invitation_id'),
            'user_id' => $request->input('user_id')
        ]);

        return \Response::json(['data' => $invitedPerson], 200);
    }

    public function update(Request $request, InvitedPerson $invitedPerson){
       $updatedInvite = $invitedPerson->update([
           'status' => $request->input('status')
        ]);

       return \Response::json(['data' => $updatedInvite], 200);


    }


}
