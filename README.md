Start the project:

```
docker compose up --build -d
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
