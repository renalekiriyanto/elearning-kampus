<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{

    use SoftDeletes;

    protected $guarded = ['id'];

    public function lecturer(){
        return $this->belongsTo(User::class, 'lecturer_id', 'id');
    }
}
