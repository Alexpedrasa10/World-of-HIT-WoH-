<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AdminController extends Controller
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
    public function createUser (Request $request)
    {
        Validator::make($request->toArray(), [
            'email' => ['required'],
            'name' => ['required'],
            'type_id' => ['required'],
        ])->validate();

        if (User::where('email', $request->email)->exists()) {
            return response()->json(['message' => 'Email already exists'], 207);
        }

        if (!Property::where([
            ['id', $request->type_id] ,
            ['category', 'TPLAY'],
            ['code', '<>' ,null]
        ])->exists()) {
            return response()->json(['message' => 'Type user id not exists'], 207);
        }
        
        $newUser = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'api_token' => Str::random(15),
            'type_id' => $request->type_id,
        ]);
        
        return response()->json(['user' => $newUser], 201);
    }

    public function createItem (Request $request)
    {
        Validator::make($request->toArray(), [
            'name' => ['required'],
            'type' => ['required'],
        ])->validate();

        $type = Property::where([
            'category' => 'TITEM',
            'code' => $request->type
        ])->first();

        if (empty($type) || $type->category !== 'TITEM') {
            return response()->json(['message' => 'Type item id not exists'], 207);        
        }

        $item = new Item();
        $item->name = $request->name;
        $item->type_id = $type->id;
        $item->shield = $request->shield;
        $item->attack = $request->attack;

        $item->save();

        return response()->json(['item' => $item], 201);
    }

    public function editItem (Request $request)
    {
        $item = Item::find($request->id);

        if (empty($item)) {
            return response()->json(['message' => "Item doesn't exists"], 207);        
        }

        $type = Property::where([
            'category' => 'TITEM',
            'code' => $request->type
        ])->first();

        if (empty($type) || $type->category !== 'TITEM') {
            return response()->json(['message' => 'Type item id not exists'], 207);        
        }

        $item->type_id = $type->id;

        // Update item if values not empty
        foreach (['name', 'shield', 'attack'] as $k) {            
            if (!empty($request->$k)) $item->$k = $request->$k;
        }

        $item->save();

        return response()->json(['item' => $item], 201);
    }

    public function getUsersUlti (Request $request)
    {
        $users = User::whereUlti(true);
        return response()->json(['users' => $users->get()], 200);
    }

}
