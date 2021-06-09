<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    protected $guarded = [];

    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function invitedPersons()
    {
        return $this->hasMany(InvitedPerson::class);
    }

    public function isOwner()
    {
        return auth()->id() == $this->user_id;
    }

}
