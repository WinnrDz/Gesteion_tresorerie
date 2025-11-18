<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Depense extends Model
{
    public function fixes():HasMany 
    {
        return $this->hasMany(Fixe::class);
    }

    public function variables():HasMany 
    {
        return $this->hasMany(Variable::class);
    }
    

    protected $guarded = [];
}
