<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Client extends Model
{
    public function entree():BelongsTo
    {
        return $this->belongsTo(Entree::class);
    }

    protected $guarded = [];
}   
