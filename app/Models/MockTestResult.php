<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class MockTestResult extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'mock_test_id', 'score', 'correct_answers', 'incorrect_answers', 'unattempted_questions',
    ];
    protected $casts = [
        'submitted_at' => 'datetime',
    ];
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function mockTest(): BelongsTo { return $this->belongsTo(MockTest::class); }
}