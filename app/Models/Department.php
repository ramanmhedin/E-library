<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo as BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany as HasMany;

class Department extends Model
{
    use HasFactory;
    protected $fillable=[
        "name",
        "college_id"];
    public function college(): BelongsTo
    {
        return $this->belongsTo(College::class, 'college_id');
    }

    public function subjects(): HasMany
    {
        return $this->hasMany(Subject::class, 'department_id');
    }
    public function users(): HasMany
    {
        return $this->hasMany(Subject::class, 'department_id');
    }
    public function students(): HasMany
    {
        return $this->hasMany(Subject::class->where("role_id","2"), 'department_id');
    }
}
