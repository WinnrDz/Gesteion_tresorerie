<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Candidate;

class Skill extends Model
{
    use HasFactory;

    public function candidates()
    {
        return $this->belongsToMany(Candidate::class)
                    ->using(CandidateSkill::class)
                    ->withPivot('level')
                    ->withTimestamps();;
    }


    protected $guarded = [];
}
