<?php

namespace Ecolso\Saas\Controllers;

use App\Http\Controllers\Controller;
use Domain\Users\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
       $users = User::query()->with(['roles'])->get();

       return Inertia::render('Users/Index', [
           'users' => $users
       ]);
   }

}
