<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class depensenom extends Model
{
    public function depenses():HasMany
    {
        return $this->hasMany(Depense::class);
    }

    protected $guarded = [];
}
