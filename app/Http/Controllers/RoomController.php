<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;

class RoomController extends Controller
{

    public function new(){

        $rooms = Room::all();

        return view('room', compact('rooms'));
    }

    public function index()
    {
        return Room::all();
    }

    public function create(Request $request)
    {   
        dd($request->all());
        return Room::create($request->all());
    }

    public function update(Room $room, Request $request)
    {
        $room->name = $request->name;
        $room->save();
        return redirect('/room/new');
    }

    public function store(Request $request){
        Room::create([
            'name' => $request->name
        ]);

        return redirect('/room/new');
    }

    public function edit(Room $room){
        return view('room_edit', compact('room'));
    }

    public function destroy(Room $room)
    {
        $room->delete();
        return redirect('/room/new');
    }
}
