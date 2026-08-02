<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = [
        'teacher_id',
        'title',
        'content'
    ];


    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}