<?php

declare(strict_types=1);

namespace KollabsBooks\BookCatalog\Infrastructure\Http;

use KollabsBooks\BookCatalog\Application\Service\BookServiceInterface;
use KollabsBooks\BookCatalog\Domain\Entity\Book;
use KollabsBooks\BookCatalog\Domain\ValueObject\Uuid;
use KollabsBooks\Shared\Infrastructure\Http\DomainRoutesInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;

class BookCatalogRoutes implements DomainRoutesInterface
{
    public static function registerRoutes(App $app): void
    {
        $app->get('/books', function (Request $request, Response $response) use ($app) {
            $bookService = $app->getContainer()->get(BookServiceInterface::class);
            $books = $bookService->getAllBooks();

            $payload = json_encode($books->toArray());

            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        });

        $app->get('/books/{id}', function (Request $request, Response $response, array $args) use ($app) {
            $bookService = $app->getContainer()->get(BookServiceInterface::class);
            $book = $bookService->getBook($args['id']);

            if (!$book) {
                $response->getBody()->write(json_encode(['error' => 'Book not found']));
                return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
            }

            $payload = json_encode($book->toArray());

            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        });
    }
}