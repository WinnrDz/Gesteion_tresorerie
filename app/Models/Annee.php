<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Annee extends Model
{
    public function mois(): HasMany 
    {
        return $this->hasMany(Mois::class);
    }

    protected $guarded = [];
}
