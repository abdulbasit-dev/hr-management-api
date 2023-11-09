<?php

namespace App\Enums;

enum Gender: int
{
    case MALE   = 0;
    case FEMALE = 1;
    case OTHER  = 2;


    public function isMale(): bool
    {
        return $this === self::MALE;
    }

    public function isFemale(): bool
    {
        return $this === self::FEMALE;
    }

    public function isOther(): bool
    {
        return $this === self::OTHER;
    }

    public function getLabelText(): string
    {
        return match ($this) {
            self::MALE   => "Male",
            self::FEMALE => "Female",
            self::OTHER  => "Other",
        };
    }

    // get from value based on name
    public static function fromName(string $name): self
    {
        return match ($name) {
            "Male"   => self::MALE,
            "Female" => self::FEMALE,
            "Other"  => self::OTHER,
        };
    }
}
