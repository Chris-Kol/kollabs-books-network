CREATE TABLE IF NOT EXISTS books (
    id VARCHAR(36) PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    stock INT NOT NULL
);

INSERT INTO books (id, title, author, price, stock) VALUES
('550e8400-e29b-41d4-a716-446655440000', 'The Great Gatsby', 'F. Scott Fitzgerald', 9.99, 100),
('6ba7b810-9dad-11d1-80b4-00c04fd430c8', 'To Kill a Mockingbird', 'Harper Lee', 12.50, 75),
('a0eebc99-9c0b-4ef8-bb6d-6bb9bd380a11', '1984', 'George Orwell', 10.99, 50),
('b0eebc99-9c0b-4ef8-bb6d-6bb9bd380a12', 'Pride and Prejudice', 'Jane Austen', 8.99, 60),
('c0eebc99-9c0b-4ef8-bb6d-6bb9bd380a13', 'Clean Code', 'Robert C. Martin', 34.99, 30),
('d0eebc99-9c0b-4ef8-bb6d-6bb9bd380a14', 'The Pragmatic Programmer', 'Andrew Hunt, David Thomas', 39.99, 25),
('e0eebc99-9c0b-4ef8-bb6d-6bb9bd380a15', 'Design Patterns', 'Erich Gamma, Richard Helm, Ralph Johnson, John Vlissides', 49.99, 20),
('f0eebc99-9c0b-4ef8-bb6d-6bb9bd380a16', 'The Kollabs Chronicle: Unraveling the Web', 'Christina Koleri', 29.99, 42),
('10eebc99-9c0b-4ef8-bb6d-6bb9bd380a17', 'Refactoring', 'Martin Fowler', 44.99, 35),
('20eebc99-9c0b-4ef8-bb6d-6bb9bd380a18', 'The Mythical Man-Month', 'Frederick Brooks Jr.', 24.99, 15);