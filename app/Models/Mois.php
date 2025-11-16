<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mois extends Model
{
    public function annee():BelongsTo
    {
        return $this->belongsTo(Annee::class);
    }
    public function periode():HasMany
    {
        return $this->hasMany(Periode::class);
    }

    protected $guarded = [];
}