<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Enrollment extends Model
{

    use SoftDeletes;

    protected $guarded = ['id'];

    public function course(){
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }
}
