<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Candidate;

class Profilecv extends Model
{
    use HasFactory;

    public function candidates()
    {
        return $this->belongsToMany(Candidate::class)
                    ->using(CandidateSkill::class)
                    ->withPivot('type')
                    ->withTimestamps();
    }


    protected $guarded = [];
}
