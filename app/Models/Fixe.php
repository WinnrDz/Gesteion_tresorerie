<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Fixe extends Model
{
    public function depense():BelongsTo
    {
        return $this->belongsTo(Depense::class);
    }

    protected $guarded = [];
}
