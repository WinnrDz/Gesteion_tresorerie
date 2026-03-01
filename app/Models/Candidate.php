<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Skill;
use App\Models\Profilecv;
use App\Models\CandidateSkill;
use App\Models\CandidateProfilecv;


class Candidate extends Model
{
    use HasFactory;

    public function skills()
    {
        return $this->belongsToMany(Skill::class)
                    ->using(CandidateSkill::class)
                    ->withPivot('level')
                    ->withTimestamps();
    }

    public function profilecvs()
    {
        return $this->belongsToMany(Profilecv::class)
                    ->using(CandidateProfilecv::class)
                    ->withPivot('type')
                    ->withTimestamps();
    }



    protected $guarded = [];
}
