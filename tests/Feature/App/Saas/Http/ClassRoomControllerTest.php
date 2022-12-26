<?php

use Domain\SchoolYears\Models\SchoolYear;
use Domain\Users\Models\User;
use Inertia\Testing\AssertableInertia;

use function Pest\Faker\faker;
use function Pest\Laravel\{actingAs, assertDatabaseHas, get, post, put};

beforeEach(function() {
    actingAs($this->user = User::factory()->withPersonalTeam()->create());

    $this->team = $this->user->ownedTeams()->first();
});

it('show rooms list', function() {
    get(
        route('app.classrooms.index', [
            'team' => $this->team,
            'year' => SchoolYear::factory()->create()
        ])
    )
    ->assertInertia(
        fn (AssertableInertia $page) => $page
            ->component('App/ClassRooms/Index')
            //->has('types', 2)
            /*->has('rooms', fn (AssertableInertia $page) => $page
                ->has('data', fn (AssertableInertia $page) => $page->has('data', 7))
            )*/
    );
});
