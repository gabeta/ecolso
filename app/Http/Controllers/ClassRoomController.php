<?php

namespace App\Http\Controllers;

use App\Models\ClassRoom;
use App\Models\Landlord\ClassRoomType;
use App\Models\Room;
use App\Table\InertiaTable;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\QueryBuilder\QueryBuilder;

class ClassRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classRooms = QueryBuilder::for(ClassRoom::class)
                    ->with(['types', 'room', 'master'])
                    ->allowedFilters([
                        'name',
                        // AllowedFilter::callback('type', fn($builder, $value) => $builder->whereHas('ecolso_main.types', fn($query) => $query->where('room_type_id', $value))),
                    ])
                    ->paginate();

        $types = ClassRoomType::all();

        $rooms = Room::all();

        return Inertia::render('App/ClassRooms/Index', [
            'classRooms' => $classRooms,
            'types' => $types->selectable('name', 'id'),
            'rooms' => $rooms->selectable('name', 'id')
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
     * @param  \App\Models\ClassRoom  $classRoom
     * @return \Illuminate\Http\Response
     */
    public function show(ClassRoom $classRoom)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ClassRoom  $classRoom
     * @return \Illuminate\Http\Response
     */
    public function edit(ClassRoom $classRoom)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ClassRoom  $classRoom
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ClassRoom $classRoom)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ClassRoom  $classRoom
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClassRoom $classRoom)
    {
        //
    }
}
