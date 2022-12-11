<?php

use Domain\SchoolYears\Exceptions\NoSchoolYearsAvailableException;
use Domain\SchoolYears\Models\SchoolYear;
use Domain\Teams\Models\Team;
use Domain\Users\Models\User;
use Ecolso\Saas\Middlewares\ResolveSchoolYearMiddleware;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

beforeEach(function() {
    $this->team = Team::factory()->create();
});

it("cant access to route when no school years available", function () {
    (new ResolveSchoolYearMiddleware())->handle(
        createRequest('get', 'teams/'.$this->team->id.'/', ['team' => $this->team]),
        fn() => new Response()
    );
})->throws(NoSchoolYearsAvailableException::class);

it("redirect to current school year when year is not defined on route", function () {
    SchoolYear::factory(3)->create([
        'is_current' => false
    ]);

    $year = SchoolYear::factory()->create([
        'is_current' => true
    ]);

    $response = (new ResolveSchoolYearMiddleware())->handle(
        createRequest('get', 'teams/'.$this->team->id.'/', ['team' => $this->team]),
        fn() => new Response()
    );

    expect($response->isRedirect(route('app.dashboard', ['team' => $this->team, 'year' => $year])))->toBeTrue();
});

it("redirect to school year", function () {
    $schools = SchoolYear::factory(3)->create([
        'is_current' => false
    ]);

    $year = $schools->first();

    SchoolYear::factory()->create([
        'is_current' => true
    ]);

    $response = (new ResolveSchoolYearMiddleware())->handle(
        createRequest('get', 'teams/'.$this->team->id.'/year/'.$year->slug, ['team' => $this->team, 'year' => $year->slug]),
        fn() => new Response()
    );

    expect($response->isRedirect())->toBeFalse();
});

it('will perform the right redirect when saas middlewre is apply', function() {
    Route::get('fake-route/{team}/year/{year?}', fn() => 'work fine')->middleware('saas');

    $year = SchoolYear::factory()->create([
        'is_current' => true
    ]);
    actingAs($user = User::factory()->withPersonalTeam()->create());
    $team = $user->ownedTeams()->first();
    $route =  'fake-route/'.$team->id.'/year';

    get($route)->assertStatus(302)->assertRedirect(route('app.dashboard', ['team' => $team, 'year' => $year]));

    $lastYear = SchoolYear::factory()->create([
        'is_current' => false
    ]);

    get($route.'/'.$lastYear->slug)->assertStatus(200);
    expect($lastYear->id)->toBe((app('currentYear')->get())->id);
});
