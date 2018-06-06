<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use SoftDeletes;

    protected $table = 'users';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $dates = ['deleted_at'];

    public function Knowledge()
    {
        return $this->hasOne('App\Model\Knowledge');
    }
}