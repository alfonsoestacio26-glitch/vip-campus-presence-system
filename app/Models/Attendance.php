<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = 'attendance';

    protected $fillable = [
        'student_id',
        'guard_id',
        'attendance_date',
        'time_in',
        'time_out',
        'status',
        'remarks',
    ];

    protected $casts = [
        'attendance_date' => 'date',
    ];

    public function getTimeInAttribute($value)
    {
        if (!$value) {
            return null;
        }
        return $value instanceof \Carbon\Carbon ? $value : \Carbon\Carbon::parse($value);
    }

    public function getTimeOutAttribute($value)
    {
        if (!$value) {
            return null;
        }
        return $value instanceof \Carbon\Carbon ? $value : \Carbon\Carbon::parse($value);
    }

    public function setTimeInAttribute($value)
    {
        if ($value instanceof \DateTimeInterface) {
            $this->attributes['time_in'] = $value->format('H:i:s');
        } else {
            $this->attributes['time_in'] = $value;
        }
    }

    public function setTimeOutAttribute($value)
    {
        if ($value instanceof \DateTimeInterface) {
            $this->attributes['time_out'] = $value->format('H:i:s');
        } else {
            $this->attributes['time_out'] = $value;
        }
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function guardProfile()
    {
        return $this->belongsTo(Guard::class, 'guard_id');
    }
}