<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Book;
use Zenstruck\Foundry\ModelFactory;

/**
 * @extends ModelFactory<Book>
 */
final class BookFactory extends ModelFactory
{
    protected static function getClass(): string
    {
        return Book::class;
    }

    protected function getDefaults(): array
    {
        return [
            'title' => self::faker()->text(255),
        ];
    }
}
