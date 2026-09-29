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
        'photo',
        'contact_number'
    ];

    /**
     * Get teacher's photo URL or a professional fallback avatar.
     */
    public function getPhotoUrlAttribute(): string
    {
        if ($this->photo && \Illuminate\Support\Facades\Storage::disk('public')->exists($this->photo)) {
            return asset('storage/' . $this->photo);
        }

        return 'https://ui-avatars.com/api/?name=' . urlencode($this->first_name . '+' . $this->last_name) . '&background=123b70&color=ffffff&size=256&bold=true';
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function announcements()
    {
        return $this->hasMany(Announcement::class);
    }
}