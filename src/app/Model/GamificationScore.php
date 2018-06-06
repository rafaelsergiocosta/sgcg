<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GamificationScore extends Model
{
    use SoftDeletes;

    protected $table = 'gamification_scores';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $dates = ['deleted_at'];
}