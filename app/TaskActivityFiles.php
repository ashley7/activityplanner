<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskActivityFiles extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
