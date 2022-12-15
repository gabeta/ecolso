<?php

use Domain\Rooms\Models\Room;
use Domain\Rooms\Models\RoomType;
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

it('can create room', function() {
    $types = RoomType::factory(3)->create([
        'room_type_id' => RoomType::factory(),
    ]);

    post(
        route('app.rooms.store', [
            'team' => $this->team,
            'year' => SchoolYear::factory()->create()
        ]),
        [
            'name' => $name = faker()->name,
            'types' => $typeIds = $types->pluck('id')->toArray(),
        ]
    )->assertStatus(302);

    $room = Room::first();
    assertDatabaseHas(Room::class, [
        'name' => $name
    ]);
    expect($room->types()->count())->toBe(3);
    expect($room->types()->pluck('id')->toArray())->toBe($typeIds);
});

it('validate requires input', function($route) {
    $route->assertSessionHasErrors(['name', 'types']);
})->with([
    'create form route' => fn() => post(route('app.rooms.store', [
        'team' => $this->team,
        'year' => SchoolYear::factory()->create()
    ])),
    'update form route' => fn() => put(route('app.rooms.update', [
        'team' => $this->team,
        'year' => SchoolYear::factory()->create(),
        'room' => Room::factory()->create([
            'team_id' => $this->team->id
        ])
    ])),
]);

it('will validate if room type exists', function($route) {
    $route->assertSessionHasErrors(['types.*'])->assertSessionDoesntHaveErrors(['name']);
})->with([
    'create form route' => fn() => post(route('app.rooms.store', [
        'team' => $this->team,
        'year' => SchoolYear::factory()->create()
    ]), [
        'name' => faker()->name,
        'types' => [1, 2, 3],
    ]),
    'update form route' => fn() => put(route('app.rooms.update', [
        'team' => $this->team,
        'year' => SchoolYear::factory()->create(),
        'room' => Room::factory()->create([
            'team_id' => $this->team->id
        ])
    ]), [
        'name' => faker()->name,
        'types' => [1, 2, 3],
    ]),
]);

it('can update room', function() {
    $types = RoomType::factory(3)->create([
        'room_type_id' => RoomType::factory(),
    ]);

    put(
        route('app.rooms.update', [
            'team' => $this->team,
            'year' => SchoolYear::factory()->create(),
            'room' => $room = Room::factory()->create([
                'team_id' => $this->team->id
            ])
        ]),
        [
            'name' => $name = faker()->name,
            'types' => $typeIds = $types->pluck('id')->toArray(),
        ]
    )->assertStatus(302);

    $room->refresh();
    expect($room->name)->toBe($name);
    expect($room->types()->count())->toBe(3);
    expect($room->types()->pluck('id')->toArray())->toBe($typeIds);
});
