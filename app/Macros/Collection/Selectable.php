<?php

namespace App\Macros\Collection;

use Illuminate\Support\Collection;

/**
 * @mixin \Illuminate\Support\Collection
 *
 * @return \Illuminate\Support\Collection
 */
class Selectable
{
    public function __invoke()
    {
        return function ($label, $value) {
            return $this->map(function($item) use ($label, $value) {
                return [
                    'label' => $item->{$label},
                    'value' => $item->{$value},
                ];
            }, new static());
        };
    }
}
