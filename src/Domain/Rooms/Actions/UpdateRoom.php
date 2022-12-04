<?php

namespace Domain\Rooms\Actions;

use App\Data\RoomFormData;
use Domain\Rooms\Models\Room;
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
