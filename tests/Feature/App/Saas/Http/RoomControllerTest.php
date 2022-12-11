<?php

use Domain\Users\Models\User;
use Inertia\Testing\AssertableInertia;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

beforeAll(function() {
    actingAs($this->user = User::factory()->withPersonalTeam()->create());
});

it('show rooms list', function() {
    get(
        testAppRoute('app.rooms.index', [

        ])
    )
    ->assertInertia(fn (AssertableInertia $page) => $page->component('App/Rooms/Index'));
});
