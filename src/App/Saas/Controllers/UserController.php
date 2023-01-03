<?php

namespace Ecolso\Saas\Controllers;

use App\Http\Controllers\Controller;
use App\Table\InertiaTable;
use Domain\Teams\Models\Team;
use Domain\Users\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\QueryBuilder\QueryBuilder;

class UserController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $users = QueryBuilder::for(User::class)
            ->with(['roles'])
            ->paginate();

        $teams = Team::all();

        return Inertia::render('Users/Index', [
            'users' => $users,
            'teams' => $teams
        ])->table(function (InertiaTable $table) {
        $table->disableGlobalSearch()
                ->addSearch('name', 'Libéllé', ['position' => 2, 'type' => 'text', 'placeholder' => 'Rechercher par le libéllé']);
        });
    }

    public function store()
    {

    }
}
