<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo as BelongsTo;

class File extends Model
{
    use HasFactory;

    protected $fillable=[
        "original_name",
        "file_name",
        "path",
        "mime_type",
        "research_id"
    ];
    public function research(): BelongsTo
    {
        return $this->belongsTo(Research::class, 'research_id');
    }
}
