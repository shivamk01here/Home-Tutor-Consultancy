<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class TutorPackage extends Model
{
    use HasFactory;
    protected $fillable = [
        'tutor_id', 'subject_id', 'package_type', 'rate', 'rate_unit', 'description'
    ];
    public function tutor(): BelongsTo { return $this->belongsTo(User::class, 'tutor_id'); }
    public function subject(): BelongsTo { return $this->belongsTo(Subject::class); }
    public function tutorPackages()
{
    return $this->hasMany(TutorPackage::class, 'user_id');
}
}
