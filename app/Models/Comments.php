<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comments extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'users_id',
        'posts_id',
        'comments_content'
    ];

    public function commentator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }
}
