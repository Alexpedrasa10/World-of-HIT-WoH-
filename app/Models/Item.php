<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Item extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'type_id',
        'shield',        
        'attack'
    ];

    public function type() :BelongsTo
    {
        return $this->belongsTo(Property::class, 'id', 'type_id');
    }

    public function users() :HasManyThrough
    {
        return $this->hasManyThrough(User::class, UserItem::class);
    }
}
