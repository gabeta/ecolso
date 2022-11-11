<?php

namespace App\Http\Controllers;

use App\Models\Landlord\RoomType;
use App\Models\Room;
use App\Table\InertiaTable;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\QueryBuilder\QueryBuilder;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rooms = QueryBuilder::for(Room::class)
                    ->with('type')
                    ->paginate();

        $types = RoomType::whereNotNull('room_type_id')->get();

        return Inertia::render('App/Rooms/Index', [
            'rooms' => $rooms
        ])->table(function (InertiaTable $table) use ($types) {
            $table->disableGlobalSearch()
                ->addSearch('name', 'Libéllé', ['position' => 2, 'type' => 'text', 'placeholder' => 'Rechercher par le libéllé'])
                ->addFilter(
                    'type',
                    'Type:',
                    $types->pluck('name', 'id')->toArray(),
                    ['position' => 2, 'placeholder' => 'Rechercher par le type']
                );
        });;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function show(Room $room)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function edit(Room $room)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Room $room)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function destroy(Room $room)
    {
        //
    }
}
