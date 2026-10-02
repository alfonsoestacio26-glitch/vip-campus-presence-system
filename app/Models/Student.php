<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Student extends Model
{
    protected $fillable = [
        'student_no',
        'first_name',
        'last_name',
        'middle_name',
        'photo',
        'gender',
        'birthdate',
        'grade_level',
        'section',
        'qr_code',
        'status',
    ];

    /**
     * Get the student's photo URL or a fallback avatar.
     */
    public function getPhotoUrlAttribute(): string
    {
        if ($this->photo && \Illuminate\Support\Facades\Storage::disk('public')->exists($this->photo)) {
            return asset('storage/' . $this->photo);
        }

        // Professional SVG fallback with student initial
        $initial = strtoupper(substr($this->first_name ?? 'S', 0, 1));
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->first_name . '+' . $this->last_name) . '&background=123b70&color=ffffff&size=256&bold=true';
    }

    /**
     * Format student name as: Surname, First Name Middle Initial.
     * Example: Dela Cruz, Juan P. (or Dela Cruz, Juan if no middle name)
     */
    public function getFormattedNameAttribute(): string
    {
        $mi = '';
        if (!empty($this->middle_name)) {
            $mi = ' ' . strtoupper(substr(trim($this->middle_name), 0, 1)) . '.';
        }

        return trim($this->last_name) . ', ' . trim($this->first_name) . $mi;
    }

    /**
     * Parents / Guardians linked to this student.
     */
    public function parents(): BelongsToMany
    {
        return $this->belongsToMany(
            ParentProfile::class,
            'student_parent',
            'student_id',
            'parent_id'
        )->withPivot('relationship');
    }

    /**
     * Student attendance records.
     */
    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }
}