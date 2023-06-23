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

        BookFactory::createMany(5);

        /** @var Registry $registry */
        $registry = $kernel->getContainer()->get('doctrine');

        /** @var BookRepository $bookRepository */
        $bookRepository = $registry->getRepository(Book::class);

        self::assertCount(5, $bookRepository->findAll());
    }
}
