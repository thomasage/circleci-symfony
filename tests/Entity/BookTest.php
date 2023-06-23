<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Book;
use App\Factory\BookFactory;
use App\Repository\BookRepository;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

final class BookTest extends KernelTestCase
{
    use ResetDatabase;
    use Factories;

    public function testSomething(): void
    {
        $kernel = self::bootKernel();

        /** @var Book $book */
        $book = BookFactory::createOne()->object();

        /** @var Registry $registry */
        $registry = $kernel->getContainer()->get('doctrine');

        /** @var BookRepository $bookRepository */
        $bookRepository = $registry->getRepository(Book::class);

        $books = $bookRepository->findAll();

        self::assertCount(1, $books);
        self::assertSame($book->getId(), $books[0]->getId());
        self::assertSame($book->getTitle(), $books[0]->getTitle());
    }
}
