<?php

namespace App\Data;

use App\Http\Requests\RoomFormRequest;
use Spatie\DataTransferObject\DataTransferObject;

class RoomFormData extends DataTransferObject
{
    public readonly String $name;

    public readonly array $types;

    public static function fromRequest(
        RoomFormRequest $request
    ): self {
        return new self([
            'name' => $request->get('name'),
            'types' => $request->get('types'),
        ]);
    }
}
