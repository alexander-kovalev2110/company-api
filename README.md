Start the project:

```
docker compose up --build -d
```

Install Composer dependencies:

```
docker compose exec php composer install
```

Create a database:

```
docker compose exec php php bin/console doctrine:database:create
```

Create tables using Doctrine migrations:

```
docker compose exec php php bin/console doctrine:migrations:migrate
```

Load the database with test data (seeders):

```
docker compose exec php php bin/console doctrine:fixtures:load
```

Request that returns data:

```
http://localhost:8080/api/companies
```

`api.http` – file that generates API requests for testing/debugging (without a frontend).
To execute the API request, click the "Send Request" button (above the API).

First, you need to generate a token using the following command and insert it into the file:

```
php bin/console app:jwt
```

If the token is not created, you need to recreate the keys:
1. Delete old keys:

```
docker compose exec php rm -rf config/jwt
```

2. Then generate new ones:

```
docker compose exec php php bin/console lexik:jwt:generate-keypair
```
And after that create a token
