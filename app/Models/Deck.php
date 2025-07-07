<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Deck extends Model
{
    protected $table = 'decks';

    protected $fillable = [
        'name',
        'description',
        'commander',
        'decklist',
        'owner_name',
        'owner_id',
    ];
    
    public function deck(): BelongsTo
    {
        return $this->belongsTo(Deck::class);
    }
    
    public function decks(): HasMany
    {
        return $this->hasMany(Deck::class, 'owner_id');
    }
}
