<?php

namespace Domain\Rooms\Actions;

use App\Data\RoomFormData;
use Domain\Rooms\Models\Room;
use Illuminate\Support\Facades\DB;

class CreateRoom
{
    public function handle(RoomFormData $data): Room
    {
        return DB::transaction(function() use ($data) {
            $room = Room::create([
                'name' => $data->name,
            ]);

            $room->types()->sync($data->types);

            return $room;
        });
    }
}
