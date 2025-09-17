<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TutorProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bio',
        'qualification',
        'experience_years',
        'police_verification_status',
        'rating',
        'location_id', // Make sure this is linked to the locations table
        'current_designation', // New
        'identity_proof_path', // New
        'packages', // New
    ];

    protected $casts = [
        'packages' => 'array',
    ];
    

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }
}