<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function tutors(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'tutor_subjects', 'subject_id', 'tutor_id')
                    ->withPivot('hourly_rate');
    }

    public function sessions(): HasMany
    {
        return $this->hasMany(Session::class);
    }
}