<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'api_token',
        'type_id',
        'life',
        'ulti',
    ];


    public function items() :HasManyThrough
    {
        return $this->hasManyThrough(Item::class, UserItem::class, 'user_id', 'id', 'id', 'item_id');
    }

    public function type() :HasOne
    {
        return $this->hasOne(Property::class, 'id', 'type_id');
    }

    public function getShield () :int
    {
        $itemsShield = $this->items()->select('items.shield')->get();
        $shield = 5;

        if (!empty($itemsShield)) {
            
            foreach ($itemsShield as $sh) {                
                $shield += $sh->shield;
            }
        }

        return $shield;
    }

    public function getAttack () :int
    {
        $itemsAttack = $this->items()->select('items.attack')->get();
        $attack = 5;

        if (!empty($itemsAttack)) {
            
            foreach ($itemsAttack as $sh) {                
                $attack += $sh->attack;
            }
        }

        return $attack;
    }
}
