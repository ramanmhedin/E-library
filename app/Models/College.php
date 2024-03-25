<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany as HasMany;

class College extends Model
{
    use HasFactory;
    protected $fillable=["name"];

    public function departments(): HasMany
    {
        return $this->hasMany(Department::class, 'college_id');
    }
    public function subjects(): HasMany
    {
        return $this->hasMany(Subject::class, 'college_id');
    }
    public function researches(): HasMany
    {
        return $this->hasMany(Research::class, 'college_id');
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'college_id');
    }
}
