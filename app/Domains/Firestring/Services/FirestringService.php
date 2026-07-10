<?php

namespace App\Domains\Firestring\Services;

use App\Domains\Firestring\Contracts\FirestringServiceInterface;
use App\Models\Firestring;

final class FirestringService implements FirestringServiceInterface
{
    public function update(
        Firestring $firestring,
        array $input
    ): Firestring {
        $data = array_intersect_key(
            $input,
            array_flip($this->editableFields())
        );

        $this->normalizeLegacyFields($data);

        $firestring->update($data);

        return $firestring->refresh();
    }

    /**
     * @return array<int, string>
     */
    private function editableFields(): array
    {
        $fields = [
            'fire_string_number',
            'distance',
            'ballistic_profile_id',
            'target',
            'relay',
            'lightdirection',
            'winddirection',
            'windspeed',
            'temperature',
            'sky_condition',
            'range_notes',
            'elevation',
            'windage',
        ];

        for ($i = 1; $i <= 20; $i++) {
            $fields[] = "shot{$i}value";
            $fields[] = "shot{$i}x";
            $fields[] = "shot{$i}y";
        }

        return $fields;
    }

    private function normalizeLegacyFields(array &$data): void
    {
        foreach ([
            'target',
            'relay',
            'lightdirection',
            'winddirection',
            'temperature',
            'sky_condition',
            'range_notes',
        ] as $field) {
            if (array_key_exists($field, $data) && $data[$field] === null) {
                $data[$field] = '';
            }
        }

        foreach ([
            'windspeed',
            'elevation',
            'windage',
        ] as $field) {
            if (! array_key_exists($field, $data) || $data[$field] === null) {
                $data[$field] = 0;
            }
        }
    }
}
