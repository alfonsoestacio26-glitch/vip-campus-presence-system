<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = [
        'user_id',
        'employee_no',
        'first_name',
        'last_name',
        'contact_number'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function announcements()
    {
        return $this->hasMany(Announcement::class);
    }
}