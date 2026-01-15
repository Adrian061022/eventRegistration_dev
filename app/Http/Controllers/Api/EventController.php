<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    // Admin ellenőrzés
    function checkAdmin(Request $request){
        return $request->user()->is_admin ?? false;
    }

    // user saját, admin minden esemény
    public function index(Request $request)
    {
        $query = $this->checkAdmin($request) ? Event::query() : $request->user()->events();
        $events = $query->get();
        return response()->json($events);
    }

    // jövőbeli események
    public function upcoming(Request $request)
    {
        $query = $this->checkAdmin($request) ? Event::query() : $request->user()->events();
        $events = $query->where('date','>=',now())->get();
        return response()->json($events);
    }

    // múltbeli események
    public function past(Request $request)
    {
        $query = $this->checkAdmin($request) ? Event::query() : $request->user()->events();
        $events = $query->where('date','<',now())->get();
        return response()->json($events);
    }

    //két dátum közé eső események
    //Query param-ot kell beállítani pl from=2026-02-20
    public function filter(Request $request){
        $query = $this->checkAdmin($request) ? Event::query() : $request->user()->events();
        
        if($request->has('from')){
            $query->where('date','>',$request->from);
        }

        if($request->has('to')){
            $query->where('date','<=',$request->to);
        }

        $events = $query->get();
        return response()->json($events);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        //
    }
}
