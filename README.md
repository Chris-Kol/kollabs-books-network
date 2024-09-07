<p align="center">
  <img src="https://media.giphy.com/media/l0MYGb1LuZ3n7dRnO/giphy.gif" alt="Welcome to the party, pal!">
</p>

# Kollabs Books Network (kollabs-books-network)
This project is our playground for implementing new technologies and sharing those experiments with our dev buddies over at [The Kollabs Chronicle](https://kollabs.dev/). It's like a sandbox, but instead of sand, we've got code. And instead of toys, we've got... well, more code.

🔧 Prerequisites

Docker (our magical container maker)
Docker Compose (the conductor of our container orchestra)

Docker and Docker Compose usually come together in most installations, but if you're not sure, run docker --version and docker-compose --version in your terminal. If either is missing, check out the official Docker documentation for installation instructions.


## 🚀 Quick Start

1. **Clone the repo:**
   ```
   git clone https://github.com/Chris-Kol/kollabs-books-network.git
   ```

2. **Navigate to the project directory:**
   ```
   cd kollabs-books-network
   ```

3. **Fire up those containers:**
   ```
   docker-compose up -d
   ```

4. **Install dependencies:**
   ```
   docker-compose exec php composer install
   ```

5. **Visit `http://localhost:8000`**

<p align="center">
  <img src="https://media.giphy.com/media/v1.Y2lkPTc5MGI3NjExd2xtNTJ2b3ZiOGx5ZnFtbjlkeThuZTZvdXpoczljamI4MWk4eDJ3ZCZlcD12MV9naWZzX3NlYXJjaCZjdD1n/puLoPc5QKdaIUazm9X/giphy.gif" alt="It's alive!">
</p>

🛠️ What's in Our Sandbox?

- PHP 8.3 (because we're living on the edge!)
- Slim Framework (our lightweight PHP micro-framework)
- MySQL (where all our book secrets are stored)
- Nginx (our trusty web server)
