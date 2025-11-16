<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Periode extends Model
{
    public function mois():BelongsTo
    {
        return $this->belongsTo(Mois::class);
    }

    public function depense():HasOne
    {
        return $this->hasOne(Depense::class);
    }

    public function entree():HasOne
    {
        return $this->hasOne(Entree::class);
    }

    protected $guarded = [];
}