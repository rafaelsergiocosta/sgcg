<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Knowledge extends Model
{
    use SoftDeletes;

    protected $table = 'knowledge';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $dates = ['deleted_at'];

    public function category()
    {
        return $this->belongsTo('App\Model\Category');
    }

    public function User()
    {
        return $this->belongsTo('App\Model\User');
    }
}