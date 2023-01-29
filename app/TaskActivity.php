<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskActivity extends Model
{

    public function attachments()
    {
        return $this->hasMany(TaskActivityFiles::class);
    }
    
}
