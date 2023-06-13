<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class posts extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nama_barang',
        'image',
        'harga',
        'jenis_barang',
        'penjual',
        'rating',
        'total_pembelian',
        'stock'
    ];

    public function writer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'penjual', 'id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comments::class, 'posts_id', 'id');
    }
}
