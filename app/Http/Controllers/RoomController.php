<?php

namespace App\Http\Controllers;

use App\Actions\Rooms\CreateRoom;
use App\Data\RoomFormData;
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
                    ->with('types')
                    ->paginate();

        $types = RoomType::whereNotNull('room_type_id')->get();

        return Inertia::render('App/Rooms/Index', [
            'rooms' => $rooms,
            'types' => $types->selectable('name', 'id')
        ])->table(function (InertiaTable $table) use ($types) {
            $table->disableGlobalSearch()
                ->addSearch('name', 'Libéllé', ['position' => 2, 'type' => 'text', 'placeholder' => 'Rechercher par le libéllé'])
                ->addFilter(
                    'type',
                    'Type:',
                    $types->pluck('name', 'id')->toArray(),
                    ['position' => 2, 'placeholder' => 'Rechercher par le type'],
                    //['mode' => 'tags']
                );
        });;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string:255'],
            'types' => ['required', 'array']
        ]);

        app(CreateRoom::class)->handle(
            RoomFormData::fromRequest($request)
        );

        return redirect()->appRoute('rooms.index');
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
