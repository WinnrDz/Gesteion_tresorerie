<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function entrees(): HasMany
    {
        return $this->hasMany(Entree::class);
    }

    public function getMontantTvaAttribute()
    {
        return $this->montant * 0.19;
    }

    public function getMontantTTCAttribute()
    {
        return $this->montant * 0.19 + $this->montant;
    }

    public function getRestAttribute()
    {
        $totalEntree = $this->entrees->sum('valeur');
        return $this->montant - $totalEntree;
    }

    public function getPercentageAttribute()
    {
        $totalEntree = $this->entrees->sum('valeur');
        return  $totalEntree * 100 / $this->montant;
    }

    public function getRestTvaAttribute()
    {
        $totalEntree = $this->entrees->sum('valeur');
        return ($this->montant - $totalEntree) * 0.19;
    }

    public function getRestTTCAttribute()
    {
        $totalEntree = $this->entrees->sum('valeur');
        return ($this->montant - $totalEntree) * 0.19 + $this->montant - $totalEntree;
    }


    protected $guarded = [];
}
