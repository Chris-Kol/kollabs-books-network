<?php

declare(strict_types=1);

namespace KollabsBooks\BookCatalog\Infrastructure\Http;

use KollabsBooks\BookCatalog\Application\Service\BookServiceInterface;
use KollabsBooks\Shared\Domain\Exception\ConflictException;
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
            $books = $bookService->findAll();

            $payload = json_encode($books->toArray());

            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        });

        $app->get('/books/{id}', function (Request $request, Response $response, array $args) use ($app) {
            $bookService = $app->getContainer()->get(BookServiceInterface::class);

            try {
                $book = $bookService->getBook($args['id']);

                if (!$book) {
                    $response->getBody()->write(json_encode(['error' => 'Book not found']));
                    return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
                }

                $payload = json_encode($book->toArray());

                $response->getBody()->write($payload);
                return $response->withHeader('Content-Type', 'application/json');
            } catch (\Exception $e) {
                $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
            }
        });

        $app->post('/books', function (Request $request, Response $response) use ($app) {
            $bookService = $app->getContainer()->get(BookServiceInterface::class);
            
            try {
                $data = json_decode($request->getBody()->getContents(), true);
                
                if (!$data) {
                    $response->getBody()->write(json_encode(['error' => 'Invalid JSON data']));
                    return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
                }

                $requiredFields = ['id', 'title', 'author', 'price', 'currency', 'stock'];
                foreach ($requiredFields as $field) {
                    if (!isset($data[$field])) {
                        $response->getBody()->write(json_encode(['error' => "Missing required field: $field"]));
                        return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
                    }
                }

                $book = $bookService->createBook(
                    $data['id'],
                    $data['title'],
                    $data['author'],
                    (float)$data['price'],
                    $data['currency'],
                    (int)$data['stock']
                );

                $payload = json_encode($book->toArray());
                $response->getBody()->write($payload);
                return $response->withStatus(201)->withHeader('Content-Type', 'application/json');
                
            } catch (ConflictException $e) {
                $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
                return $response->withStatus(409)->withHeader('Content-Type', 'application/json');
            } catch (\Exception $e) {
                $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
                return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
            }
        });

        $app->put('/books/{id}', function (Request $request, Response $response, array $args) use ($app) {
            $bookService = $app->getContainer()->get(BookServiceInterface::class);
            
            try {
                $data = json_decode($request->getBody()->getContents(), true);
                
                if (!$data) {
                    $response->getBody()->write(json_encode(['error' => 'Invalid JSON data']));
                    return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
                }

                // Check if book exists
                $existingBook = $bookService->getBook($args['id']);
                if (!$existingBook) {
                    $response->getBody()->write(json_encode(['error' => 'Book not found']));
                    return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
                }

                $requiredFields = ['title', 'author', 'price', 'currency', 'stock'];
                foreach ($requiredFields as $field) {
                    if (!isset($data[$field])) {
                        $response->getBody()->write(json_encode(['error' => "Missing required field: $field"]));
                        return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
                    }
                }

                $book = $bookService->updateBook(
                    $args['id'],
                    $data['title'],
                    $data['author'],
                    (float)$data['price'],
                    $data['currency'],
                    (int)$data['stock']
                );

                $payload = json_encode($book->toArray());
                $response->getBody()->write($payload);
                return $response->withHeader('Content-Type', 'application/json');
                
            } catch (\Exception $e) {
                $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
                return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
            }
        });

        $app->delete('/books/{id}', function (Request $request, Response $response, array $args) use ($app) {
            $bookService = $app->getContainer()->get(BookServiceInterface::class);
            
            try {
                // Check if book exists
                $existingBook = $bookService->getBook($args['id']);
                if (!$existingBook) {
                    $response->getBody()->write(json_encode(['error' => 'Book not found']));
                    return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
                }

                $deleted = $bookService->remove($args['id']);
                
                if ($deleted) {
                    $response->getBody()->write(json_encode(['message' => 'Book deleted successfully']));
                    return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
                } else {
                    $response->getBody()->write(json_encode(['error' => 'Failed to delete book']));
                    return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
                }
                
            } catch (\Exception $e) {
                $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
                return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
            }
        });
    }
}