<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Variables extends Model
{
    public function depense():HasOne
    {
        return $this->hasOne(Depense::class);
    }

    protected $guarded = [];
}
