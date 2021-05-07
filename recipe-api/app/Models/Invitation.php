<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;


class Invitation extends Model implements HasMedia
{
    protected $guarded = [];

    use HasFactory, InteractsWithMedia;

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function invitedPerson(){
        return $this->hasMany(InvitedPerson::class);
    }

    public function image(){
        if($this->media->first()){
            return $this->media->first()->getFullUrl();
        }

        return null;

    }

    public function isOwner(){
        return auth()->id() == $this->user_id;
    }

}
