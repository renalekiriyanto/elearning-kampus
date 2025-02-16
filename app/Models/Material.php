<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Material extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    public function courses(){
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }
}
