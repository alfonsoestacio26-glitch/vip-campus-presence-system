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
        'contact_number',
        'section',
        'grade_level'
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


    /**
     * Get assigned sections for the teacher as an array.
     * Supports single section or multiple comma-separated sections.
     */
    public function getAssignedSectionsAttribute(): array
    {
        if (empty($this->section)) {
            return [];
        }

        return array_values(array_filter(array_map('trim', explode(',', $this->section))));
    }

    /**
     * Get students belonging to the teacher's assigned section(s).
     */
    public function students()
    {
        return Student::whereIn('section', $this->assigned_sections);
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