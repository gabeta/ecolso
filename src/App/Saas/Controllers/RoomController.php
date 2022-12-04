<?php

namespace Ecolso\Saas\Controllers;

use App\Data\RoomFormData;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoomFormRequest;
use App\Models\Landlord\SchoolYear;
use App\Table\InertiaTable;
use Domain\Rooms\Actions\CreateRoom;
use Domain\Rooms\Actions\UpdateRoom;
use Domain\Rooms\Models\Room;
use Domain\Rooms\Models\RoomType;
use Domain\Teams\Models\Team;
use Inertia\Inertia;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = QueryBuilder::for(Room::class)
                    ->with('types')
                    ->allowedFilters([
                        'name',
                        // AllowedFilter::callback('type', fn($builder, $value) => $builder->whereHas('ecolso_main.types', fn($query) => $query->where('room_type_id', $value))),
                    ])
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
        });
    }

    public function store(RoomFormRequest $request)
    {
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

    public function update(RoomFormRequest $request, Team $team, SchoolYear $year, Room $room)
    {
        app(UpdateRoom::class)->handle(
            $room,
            RoomFormData::fromRequest($request)
        );

        return redirect()->appRoute('rooms.index');
    }

    public function destroy(Room $room)
    {
        //
    }
}
