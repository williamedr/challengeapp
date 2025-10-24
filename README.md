
## Challenge App

Order Management API serving to multiples clients.

This was implemented based on a single-database tenant without use any tenant package.

Initially there are 3 users types:

- __Admin__: This user can access to all the resources in the API like Orders, Invoices, Clients, Products. They are not associated to Clients.
  - __Orders__: No filtered.
  - __Invoices__: No filtered.
  - __Products__: No filtered.
  - __Clients__: No filtered.

- __Manager__: This user can access to all the resources in the API like Orders, Invoices, Clients, Products. They are associated to one or more Clients.
  - __Orders__: No filtered.
  - __Invoices__: No filtered.
  - __Products__: No filtered.
  - __Clients__: No filtered.

- __Client User__: This user can access to the resources in the API with the associated client_id or user_id. They are associated to one or more Clients.
  - __Orders__: Filtered by client_id and user_id.
  - __Invoices__: Filtered by client_id.
  - __Products__: No filtered.
  - __Clients__: Filtered by client_id.


## Installation

### Docker

- Create Docker Container:

  - `docker-compose up -d`

- Run the Database Migration into the Container:
  - `docker-compose exec challengeapp php artisan migrate`


## DB Seeder

Files:

- DatabaseSeeder
- OrderSeeder

Action:

- Create 3 Clients

- Create 2 Admin users

- Create 2 Client users

- Create 20 Products

- Create 20 Orders with 1 to 4 items.

- Create 1 Client Manager User

- Run the Database Seeder:
  - `docker-compose exec challengeapp php artisan db:seed`


## Process Queue

After the migrate and seed execution, you should run the below command, to process the jobs enqueued by the Order creation action to generate the Invoces associated to the Orders, and generate the Notifications too in the notifications table.

`docker-compose exec challengeapp php artisan queue:work`


## Testing

Files:

- Feature/AuthenticatedApiTest
- Feature/OrderTest

- Execute the testing process:
  - `docker-compose exec challengeapp php artisan test`



## Postman
Collection Link [https://github.com/williamedr/challengeapp/blob/main/apidocs/Challenge.postman_collection.json]


## Developer

William Dominguez ([williamedr@gmail.com])

GitHub Profile [https://github.com/williamedr]

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
