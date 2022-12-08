<?php

use Domain\SchoolYears\Exceptions\NoSchoolYearsAvailableException;
use Domain\SchoolYears\Models\SchoolYear;
use Domain\Teams\Models\Team;
use Domain\Tenants\Models\Tenant;
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

it('will perform the right redirect when saas middlewre is apply', function() {
    Route::get('fake-route/{team}/year/{year?}', fn() => 'work fine')->middleware('saas');

    $route =  'fake-route/'.$this->team->id.'/year';
    $year = SchoolYear::factory()->create([
        'is_current' => true
    ]);

    get($route)->assertStatus(302)->assertRedirect(route('app.dashboard', ['team' => $this->team, 'year' => $year]));

    $lastYear = SchoolYear::factory()->create([
        'is_current' => false
    ]);

    actingAs(User::factory()->create());

    get($route.'/'.$lastYear->slug)->assertStatus(200);
});
