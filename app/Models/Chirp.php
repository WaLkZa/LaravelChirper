<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Chirp extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'content'
    ];

    protected $casts = [
        'date_added' => 'datetime:Y-m-d',
    ];

    public function userLikes(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'likes');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
