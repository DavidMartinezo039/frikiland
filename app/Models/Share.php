<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Share extends Model
{
    protected $fillable = [
        'user_id',
    ];

    public function shareable()
    {
        return $this->morphTo();
    }
}
