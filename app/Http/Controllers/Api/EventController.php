<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    function checkAdmin(Request $request){
        return $request->user()->is_admin ?? false;
    }

    public function index(Request $request)
    {
        $query = $this->checkAdmin($request) ? Event::query() : $request->user()->events();
        $events = $query->get();
        return response()->json($events);
        
    }

    public function upcoming(Request $request)
    {
        $query = $this->checkAdmin($request) ? Event::query() : $request->user()->events();
        $events = $query->where('date', '>', now())->get();
        return response()->json($events);
        
    }

    public function past(Request $request)
    {
        $query = $this->checkAdmin($request) ? Event::query() : $request->user()->events();
        $events = $query->where('date', '<', now())->get();
        return response()->json($events);
        
    }


    //két dátum közé eső események lekérdezése
    public function filter(Request $request)
    {;

        $query = $this->checkAdmin($request) ? Event::query() : $request->user()->events();

        if($request->has('from')){
            $query->where('date','>',$request->from);
        }

        if($request->has('to')){
            $query->where('date','<',$request->to);
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
