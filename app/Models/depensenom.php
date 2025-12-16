<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DepenseNom extends Model
{
    use HasFactory;

    public function depenses():HasMany
    {
        return $this->hasMany(Depense::class);
    }

    protected $guarded = [];
}
