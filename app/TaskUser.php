<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskUser extends Model
{
    public function user($var = null)
    {
        return $this->belongsTo(User::class);
    }
}
