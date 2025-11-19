<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Depense extends Model
{
    public function depense_nom():BelongsTo
    {
        return $this->belongsTo(Depense_nom::class);
    }
    

    protected $guarded = [];
}
