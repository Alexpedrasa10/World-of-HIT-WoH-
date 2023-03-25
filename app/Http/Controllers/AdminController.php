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
    
    public function createUser (Request $request)
    {
        Validator::make($request->toArray(), [
            'email' => ['required'],
            'name' => ['required'],
            'type' => ['required'],
        ])->validate();

        if (User::where('email', $request->email)->exists()) {
            return response()->json(['message' => 'Email already exists'], 207);
        }

        $type = Property::where([
            'category' => 'TPLAY',
            'code' => $request->type
        ])->first();

        if (empty($type)) {
            return response()->json(['message' => 'Type item id not exists'], 207);        
        }
        
        $newUser = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'api_token' => Str::random(15),
            'type_id' => $type->id,
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
