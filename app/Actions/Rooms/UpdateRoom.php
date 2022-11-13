<?php

namespace App\Actions\Rooms;

use App\Data\RoomFormData;
use App\Models\Room;
use Illuminate\Support\Facades\DB;

class UpdateRoom
{
    public function handle(Room $room, RoomFormData $data): Room
    {
        return DB::transaction(function() use ($room, $data) {
            $room->update([
                'name' => $data->name,
            ]);

            $room->types()->sync($data->types);

            return $room;
        });
    }
}
