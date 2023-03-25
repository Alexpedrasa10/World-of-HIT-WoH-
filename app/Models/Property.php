<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'code',
        'description',        
    ];

    public function users() :HasMany
    {
        return $this->hasMany(User::class, 'type_id', 'id');
    }

    public function items() :HasMany
    {
        return $this->hasMany(Item::class, 'type_id', 'id');
    }
}
