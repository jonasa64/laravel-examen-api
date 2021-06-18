<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use Illuminate\Http\Request;
use App\Models\InvitedPerson;
use Illuminate\Support\Facades\DB;


class InvitedPersonController extends Controller
{


    public function store(Request $request)
    {
        for ($i = 0; $i < count($request->data); $i++) {
            $invitedPersons[] = [
                "invitation_id" => $request->id,
                "user_id" => $request->data[$i]
            ];
        }
        InvitedPerson::insert($invitedPersons);
        return response()->json(['data' => "invitations created"], 201);
    }

    public function update(Request $request, Invitation $invitedPerson)
    {
        DB::update('UPDATE invited_persons SET status = ? WHERE user_id = ? and invitation_id = ?', [$request->input('status'), auth()->id(), $invitedPerson->id]);

        $invitedTo = DB::table('invited_persons')->join('invitations', 'invitation_id', '=', 'invitations.id')->select('invited_persons.*', 'invitations.*')->where('invited_persons.user_id', '=', auth()->id())->get();

        return response()->json(['invitedTo' => $invitedTo], 200);


    }


}
