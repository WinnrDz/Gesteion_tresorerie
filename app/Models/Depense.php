<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Depense extends Model
{
    public function depenseNom():BelongsTo
    {
        return $this->belongsTo(DepenseNom::class,'depensenom_id');
    }
    

    protected $guarded = [];
}
