<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Session extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id', 'tutor_id', 'tutor_package_id', 'session_date', 'session_time', 'status', 'payment_status'
    ];
    public function student(): BelongsTo { return $this->belongsTo(User::class, 'student_id'); }
    public function tutor(): BelongsTo { return $this->belongsTo(User::class, 'tutor_id'); }
    public function tutorPackage(): BelongsTo { return $this->belongsTo(TutorPackage::class); }
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}