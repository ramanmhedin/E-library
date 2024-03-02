<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo as BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany as HasMany;

class Research extends Model
{
    use HasFactory;

// status => ["draft", "under_review", "progress", "under_evaluate","publish","reject"]
    protected $fillable=[
        "title",
        "description",
        "abstract",
        "status",
        "marks",
        "comments",
        "prepared_at",
        "administer_answered_at",
        "student_id",
        "teacher_id",
        "administer_id",
        "impact_factor",
        "subject_id",
        "college_id",
        "plagiarism_percentage"
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }
   public function college(): BelongsTo
    {
        return $this->belongsTo(College::class, 'college_id');
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function administer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'administer_id');
    }

    public function files(): HasMany
    {
        return $this->hasMany(File::class, 'research_id');
    }
}
