<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvitedPerson extends Model
{
    use HasFactory;
    protected $table = 'invited_persons';
    protected $guarded = [];
    public function invitation(){
        return $this->belongsTo(Invitation::class);
    }

    public function users(){
        return $this->hasMany(User::class);
    }
}
