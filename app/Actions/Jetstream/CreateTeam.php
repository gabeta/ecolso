<?php

namespace App\Actions\Jetstream;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Laravel\Jetstream\Contracts\CreatesTeams;
use Laravel\Jetstream\Events\AddingTeam;
use Laravel\Jetstream\Jetstream;

class CreateTeam implements CreatesTeams
{
    /**
     * Validate and create a new team for the given user.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return mixed
     */
    public function create($user, array $input)
    {
        Gate::forUser($user)->authorize('create', Jetstream::newTeamModel());

        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'director' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'string', 'max:255'],
            'mobile' => ['required', 'string', 'max:10'],
            'telephone' => ['nullable', 'string', 'max:10'],
        ])->validateWithBag('createTeam');

        AddingTeam::dispatch($user);

        $user->switchTeam($team = $user->ownedTeams()->create([
            'name' => $input['name'],
            'email' => $input['email'] ?? null,
            'mobile' => $input['mobile'],
            'telephone' => $input['telephone'] ?? null,
            'director' => $input['director'],
            'personal_team' => false,
        ]));

        return $team;
    }
}
