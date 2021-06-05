<?php

declare(strict_types=1);

namespace Test\Enums;

use NeutronStars\Enum\Enum;

class Language extends Enum
{
    public const EN = 'English';
    public const FR = 'French';
    public const DE = 'Germany';
    public const ES = 'Spanish';

    /**
     * @var string
     */
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}