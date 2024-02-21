<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo as BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany as HasMany;

class Subject extends Model
{
    use HasFactory;
    protected $fillable=[
        "name",
        "description",
        "academic_degree",
        "department_id",
        "college_id"
    ];
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
    public function college(): BelongsTo
    {
        return $this->belongsTo(College::class, 'college_id');
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'subject_id');
    }

    public function researches(): HasMany
    {
        return $this->hasMany(Research::class, 'subject_id');
    }
}
