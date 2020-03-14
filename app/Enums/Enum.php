<?php

namespace App\Enums;

use Illuminate\Support\Collection;

class Enum
{

    /**
     * @param array $strings
     *
     * @return bool
     */
    public static function contains(array $strings): bool
    {
        $enums = static::enums();

        foreach ($strings as $string) {
            if (!\in_array($string, $enums, true)) {
                return false;
            }
        }

        return !empty($strings);
    }

    /**
     * @return array
     * @throws
     */
    public static function enums(): array
    {
        return (new \ReflectionClass(static::class))
            ->getConstants();
    }

    /**
     * @return Collection
     */
    public static function collection(): Collection
    {
        return new Collection(static::enums());
    }

}
