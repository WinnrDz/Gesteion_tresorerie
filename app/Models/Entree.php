<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Entree extends Model
{
    public function clients():HasMany
    {
        return $this->hasMany(Client::class);
    }


    protected $guarded = [];
}
