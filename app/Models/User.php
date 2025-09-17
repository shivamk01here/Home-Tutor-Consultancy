<?php

namespace App\Models;

use App\Models\TutorPackage; // Make sure this is at the top
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

use App\Models\Role;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'is_verified',
        'profile_photo_path',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the role associated with the user.
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Get the tutor profile associated with the user.
     */
    public function tutorProfile(): HasOne
    {
        return $this->hasOne(TutorProfile::class, 'user_id');
    }

    /**
     * Get the student profile associated with the user.
     */
    public function studentProfile(): HasOne
    {
        return $this->hasOne(StudentProfile::class, 'user_id');
    }

    /**
     * The subjects that belong to the tutor.
     */
    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class, 'tutor_subjects', 'tutor_id', 'subject_id')
                    ->withPivot('hourly_rate');
    }


    public function subjectsOfInterest(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class, 'student_subject', 'student_id', 'subject_id');
    }

    /**
     * Get the sessions where the user is a tutor.
     */
    public function tutoredSessions(): HasMany
    {
        return $this->hasMany(Session::class, 'tutor_id');
    }

    /**
     * Get the sessions where the user is a student.
     */
    public function studentSessions(): HasMany
    {
        return $this->hasMany(Session::class, 'student_id');
    }

    /**
     * Get the reviews given to the user (as a tutor).
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'tutor_id');
    }


    public function tutorPackages()
    {
        return $this->hasMany(TutorPackage::class, 'tutor_id');
    }

    /**
     * Get the sessions associated with the student.
     */
    public function sessionsAsStudent()
    {
        return $this->hasMany(Session::class, 'student_id');
    }

    /**
     * Get the sessions associated with the tutor.
     */
    public function sessionsAsTutor()
    {
        return $this->hasMany(Session::class, 'tutor_id');
    }


    public function resources()
{
    return $this->hasMany(LearningResource::class, 'tutor_id');
}
}