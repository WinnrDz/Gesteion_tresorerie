<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CandidateProfilecv extends Pivot
{
    use HasFactory;

    protected $table = 'candidate_profilecv';

    protected $guarded = [];
}
