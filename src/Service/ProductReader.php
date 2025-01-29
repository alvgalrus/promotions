<?php declare(strict_types=1);

namespace App\Service;

interface ProductReader
{
    public function load(): array;
}