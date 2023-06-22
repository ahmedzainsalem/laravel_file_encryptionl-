<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $fillable = ['name','public_key','private_key'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
