<?php

declare(strict_types=1);

namespace Test\Enums;

use NeutronStars\Enum\Enum;

class Users extends Enum
{
    public const JOHN_DOE   = ['John', 'Doe', 18, false];
    public const MIKE_BROWN = ['Mike', 'Brown', 27, true];

    /** @var string $firstname */
    private $firstname;
    /** @var string $lastname */
    private $lastname;
    /** @var int $age */
    private $age;
    /** @var bool $vip */
    private $vip;

    public function __construct(String $firstname, string $lastname, int $age, bool $vip)
    {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->age = $age;
        $this->vip = $vip;
    }

    /**
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @return string
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * @return int
     */
    public function getAge(): int
    {
        return $this->age;
    }

    /**
     * @return bool
     */
    public function isVip(): bool
    {
        return $this->vip;
    }
}