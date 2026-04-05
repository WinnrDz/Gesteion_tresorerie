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
                    ->withTimestamps();
    }

    public function profilecvs()
    {
        return $this->belongsToMany(Profilecv::class)
                    ->using(CandidateProfilecv::class)
                    ->withTimestamps();
    }



    protected $guarded = [];
}
