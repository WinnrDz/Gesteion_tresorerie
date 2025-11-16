<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Depense extends Model
{
    public function periode():HasOne
    {
        return $this->hasOne(Periode::class);
    }

    public function fixes():HasOne
    {
        return $this->hasOne(Fixes::class);
    }

    public function variables():HasOne
    {
        return $this->hasOne(Variables::class);
    }

    protected $guarded = [];
}
