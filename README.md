# MoneyFlex Task

This is the MoneyFlex Task project, a simple application with an API powered by Laravel. It's set up with Docker and comes with Swagger docs for easy API exploration.

## Quick Start

Follow these steps to get the project up and running with Docker.

### Prerequisites

- [Docker](https://www.docker.com/get-started) (Including Docker Compose)
- [PHP](https://www.php.net/) >= 8.x (But don't worry, Docker takes care of this)
- [Laravel](https://laravel.com/) 10.x (It's the backbone of this app)

### Setting Up Docker

1. **Clone the repo:**

   ```bash
   git clone https://github.com/yourusername/moneyflex-task.git
   cd moneyflex-task
   ```

2. **Copy `.env.example` to `.env`:**

   ```bash
   cp .env.example .env
   ```

   If you need to change any environment settings (like database credentials), do it here.

3. **Build and run Docker containers:**

   This will start everything you need:

   ```bash
   docker-compose up --build
   ```

4. **Run migrations:**

   Make sure the database is set up by running:

   ```bash
   docker-compose exec app php artisan migrate
   ```

5. **Access the app:**

   Now, the app should be running on `http://localhost` (or whichever port you've set in your `docker-compose.yml`).

---

## Swagger API Docs

MoneyFlex Task comes with Swagger API docs for easy API testing and exploration. Here's how to check them out:

1. **Visit the Swagger docs UI:**

   After the app is running, go to:

   ```
   http://localhost:8080/docs
   ```

   You’ll see a nice UI where you can browse all API endpoints, see how they work, and even test them directly!

2. **Regenerate Docs (if needed):**

   If you make any changes to the API, you can regenerate the docs with this command:

   ```bash
   docker-compose exec app php artisan swagger-lume:generate
   ```

   This will refresh the Swagger docs (`api-docs.json`) to reflect any changes.

---

## API Testing

To test the API, you can use Swagger UI (mentioned above), or tools like [Postman](https://www.postman.com/) or [Insomnia](https://insomnia.rest/). For example:

- To get the list of customers, hit:

  ```
  GET http://localhost/api/customers
  ```

  Make sure to include your `Authorization` header with a Bearer token if needed.

---