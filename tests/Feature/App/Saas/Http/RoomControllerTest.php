<?php

use Domain\Rooms\Models\Room;
use Domain\Rooms\Models\RoomType;
use Domain\SchoolYears\Models\SchoolYear;
use Domain\Users\Models\User;
use Inertia\Testing\AssertableInertia;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

beforeEach(function() {
    actingAs($this->user = User::factory()->withPersonalTeam()->create());

    $this->team = $this->user->ownedTeams()->first();
});

it('show rooms list', function() {
    RoomType::factory(4)->create();

    RoomType::factory(2)->create([
        'room_type_id' => RoomType::factory(),
    ]);

    Room::factory(7)->create([
        'team_id' => $this->team->id
    ]);

    get(
        route('app.rooms.index', [
            'team' => $this->team,
            'year' => SchoolYear::factory()->create()
        ])
    )
    ->assertInertia(
        fn (AssertableInertia $page) => $page
            ->component('App/Rooms/Index')
            ->has('types', 2)
            /*->has('rooms', fn (AssertableInertia $page) => $page
                ->has('data', fn (AssertableInertia $page) => $page->has('data', 7))
            )*/
    );
});
it('show rooms list', function() {
    $types = RoomType::factory(3)->create([
        'room_type_id' => RoomType::factory(),
    ]);

    get(
        route('app.rooms.index', [
            'team' => $this->team,
            'year' => SchoolYear::factory()->create()
        ])
    );
});
