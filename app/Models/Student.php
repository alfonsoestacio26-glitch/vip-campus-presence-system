<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'student_no',
        'first_name',
        'last_name',
        'middle_name',
        'gender',
        'birthdate',
        'grade_level',
        'section',
        'qr_code',
        'status'
    ];


    public function parents()
    {
        return $this->belongsToMany(
            ParentProfile::class,
            'student_parent'
        );
    }


    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }
}
