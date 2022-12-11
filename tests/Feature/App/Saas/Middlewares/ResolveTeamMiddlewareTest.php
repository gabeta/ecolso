<?php

use Domain\SchoolYears\Models\SchoolYear;
use Domain\Teams\Models\Team;
use Domain\Users\Models\User;
use Ecolso\Saas\Middlewares\ResolveTeamMiddleware;
use Illuminate\Support\Facades\Route;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

beforeEach(function() {
    $this->user = User::factory()->withPersonalTeam()->create();

    Route::get('fake-route/{team}/year/{year?}', fn() => 'work fine')->middleware(ResolveTeamMiddleware::class);
});

it("user can't access to which does not belong to him", function () {
    $team = Team::factory()->create();
    actingAs($this->user);

    get('fake-route/'.$team->id.'/year')->assertStatus(404);

    expect(app('currentTeam')->get())->toBeNull();
});

it("user can access his project", function () {
    $team = Team::first();
    actingAs($this->user);

    get('fake-route/'.$team->id.'/year')->assertStatus(200);

    expect($team->id)->toBe((app('currentTeam')->get())->id);
});


it('user can access his project when saas middlewre is apply', function() {
    Route::get('fake-route-2/{team}/year/{year?}', fn() => 'work fine')->middleware('saas');
    $team = Team::first();
    actingAs($this->user);
    $year = SchoolYear::factory()->create([
        'is_current' => true
    ]);

    get('fake-route-2/'.$team->id.'/year/'.$year->slug)->assertStatus(200);

    expect($team->id)->toBe((app('currentTeam')->get())->id);
});

