<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Property;
use App\Models\User;
use App\Models\UserItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    /* 
        Como administrador quiero dar de alta un jugador. OK
        Como administrador quiero dar de alta y modificar items. 
        Como jugador quiero equiparme un item.
        Como jugador quiero atacar a otro jugador con un golpe cuerpo a cuerpo.
        Como jugador quiero atacar a otro jugador con un golpe a distancia.
        Como jugador quiero atacar a otro jugador con mi ulti.
        Como administrador queremos ver que jugadores pueden tirar su ulti. 
    */
    
    public function assignItem (Request $request)
    {
        Validator::make($request->toArray(), [
            'item_id' => ['required'],
        ])->validate();

        $item = Item::whereId($request->item_id)->first();

        if (empty($item)) {        
            return response()->json(['message' => "Not exists item with id {$request->item_id}"], 207);        
        }

        $user = User::whereApiToken($request->bearerToken())->first();
        $items = $user->items()->where(['items.type_id' => $item->type_id])->exists();

        if ($items) {
            return response()->json(['message' => "The user already has an item of this type."], 207);        
        }

        UserItem::firstOrCreate([
            'user_id' => $user->id,
            'item_id' => $request->item_id
        ]);

        return response()->json(['message' => "Item assigned succesfully"], 200);  
    }


    public function attackBodyToBody (Request $request)
    {
        $duel = $this->getDuel($request);

        if (isset($duel->err)) {
            return response()->json(['message' => $duel->err], 207);
        }

        $victim = $duel->victim;
        $aggressor = $duel->aggressor;

        // $items = $aggressor->items();

        // if (empty($items->get())) {
        //     return response()->json(['message' => "Aggressor don't have any items assigned."], 207);        
        // }

        // $prop = Property::select('id')->where(['category' => 'TITEM','code' => 'WAEA'])->first();
        // $arm = $items->where('items.type_id', $prop->id)->first();

        // if (empty($arm)) {
        //     return response()->json(['message' => "Aggressor don't have any items of type attack assigned."], 207);
        // }

        $victimShield = $victim->getShield();
        $aggressorAttack = $aggressor->getAttack();

        $quit = $aggressorAttack > $victimShield ? $aggressorAttack - $victimShield : 1;
        $victim->life = $victim->life - ($quit);
        $victim->save();

        $aggressor->ulti = true;
        $aggressor->save();

        $aggressor->powerAttack = $aggressorAttack;
        $victim->shield = $victimShield;

        return response()->json([
            'message' => "Attack succesfully.",
            'victim' => $victim,
            'aggressor' => $aggressor
        ], 200);
    }


    public function rangedAttack (Request $request)
    {
        $duel = $this->getDuel($request);

        if (isset($duel->err)) {
            return response()->json(['message' => $duel->err], 207);
        }

        $victim = $duel->victim;
        $aggressor = $duel->aggressor;

        $victimShield = $victim->getShield();
        $aggressorAttack = $aggressor->getAttack() * 0.8;

        $quit = $aggressorAttack > $victimShield ? $aggressorAttack - $victimShield : 1;
        $victim->life = $victim->life - $quit;
        $victim->save();

        $aggressor->ulti = false;
        $aggressor->save();

        $aggressor->powerAttack = $aggressorAttack;
        $victim->shield = $victimShield;

        return response()->json([
            'message' => "Ranged attack succesfully.",
            'victim' => $victim,
            'aggressor' => $aggressor
        ], 200);
    }

    public function ulti (Request $request)
    {
        $duel = $this->getDuel($request);

        if (isset($duel->err)) {
            return response()->json(['message' => $duel->err], 207);
        }

        $victim = $duel->victim;
        $aggressor = $duel->aggressor;

        if (!$aggressor->ulti) {
            return response()->json(['message' => "Player doesn't have ulti"], 207);
        }

        $victimShield = $victim->getShield();
        $aggressorAttack = $aggressor->getAttack() * 2;

        $quit = $aggressorAttack > $victimShield ? $aggressorAttack - $victimShield : 1;
        $victim->life = $victim->life < $quit ? 0 : $victim->life - $quit;
        $victim->save();

        $aggressor->ulti = false;
        $aggressor->save();

        $aggressor->powerAttack = $aggressorAttack;
        $victim->shield = $victimShield;

        return response()->json([
            'message' => "Ulti succesfully.",
            'victim' => $victim,
            'aggressor' => $aggressor
        ], 200);
    }


    public function getDuel (Request $request) 
    {
        Validator::make($request->toArray(), [
            'victim_id' => ['required'],
        ])->validate();

        $aggressor = User::where('api_token', $request->bearerToken())->first();
        $victim = User::find($request->victim_id);

        if (empty($victim)) {
            return (object)['err' => "Not exists player with id {$request->victim_id}"];
        }

        if ($victim->id == $aggressor->id) {
            return (object)['err' => "You can't attack yourself."];
        }

        if ($victim->life == 0) {
            return (object)['err' => "The player {$victim->name} don't have life"];
        }

        return (object)[
            'aggressor' => $aggressor,
            'victim' => $victim
        ];
    }
}
