# exchanger
Microservice app to transfer funds between wallets

# Service topology
There are 5 services: 
- nginx - used to handle connections
- api-gateway - which is entry point of the app (rest api)
- users - responsible for users management, uses users db
- finance-manager - responsible for walets management and funds transfering, uses finance db
- db - postgres instance with 2 databases used to store data

# Architecture
- The entry point of the app is api/public/api-gateway/index.php

- There is 1 main controller located in api/app/ApiGateway/Http/Controllers/FinanceManagerController.php
Also there is auth middleware that fetches info about user by userId and token (we assume, that user have already logged in the app and received tocken)

- User fetching is performed with api/app/CQRS/Queries/GetUserQuery
There are another possible query examples without full workflow realization in api/app/CQRS/Queries/

- Funds transfer is performed with api/app/CQRS/Commands/CreateTransactionCommand

- Commands and Queries are dispatched by the api/app/Services/Dispatcher.php
It may be splitted into CommandDispatcher and QueryDispancher.

- In prod environment it would be better to use MQ and contracts or some middleware service with load balancer responsible for routing between services. It's better for isolation and scalability. Also in prod environment there are should be Api Tokens for services to verify requests.

- In this example I use serialized classes and RPC commands for communication between services, in prod env serialization should be replaced with Json/binary protocols/XML/Soap depending on app requirments.

- Request processing on the consuming service side is performed via Handlers which are responsible for business logic. In real app It may be additional Domain Logic layer, but for this example I've decided that this separation is enough.

- Handlers are resolved by Resolver.php (for example api/app/FinanceManager/CQRS/Resolver.php). Communication with database is performed via Repositories. There are plases for improvements here: add builders for objects, use DTO's and VO's, composite Entities/VO's where it's needed.

- Validation is performed by validators e.g. api/app/Finance/Manager/Validators/CreateTransactionValidator.php

- Also middlewares may be used for some cases of validation and restrictions.

- Example of test is located in api/tests/Unit

- Business logic was made framework independent so may be moved with minor changes to different setup

# Setup and deployment
1. add to your hosts file: 127.0.0.1    exchanger.test exchanger.users.test exchanger.finance-manager.test
2. Go to the root folder of the app
3. Run docker-compose up -d --build

For simplification .env files were added to repository. On production they should be created during the deployment process and should not be stored here.

#Performing request
For transfer request Postman may be used
```
request type: POST
request url: http://exchanger.test/transactions
request body: 
{
  "walletFrom": "2904e3ef-c438-4ec2-8345-1de5071a7f16",
  "walletFromKey": "Hthvcbgtt",
  "walletTo": "96af9fb1-e55b-45c6-abda-3fecc4957d59",
  "amount": 25,
  "userId": "65910a2b-4c0e-4486-9c8e-ffa87cf6accb",
  "token": "$2y$10$rTFfToPjJvy9WF2AgPE7Seh5YvywR6wZ8wQvq.uwiYi5rvW/qONx6"
}
```


# Assuptions and decisions, what should be improved
The assumptions was made for this app - we use integers in db to store money data, calculate in cents, if it would be bitcoins or some other cryptocurrencies int may be replaced with bigint and calculation will be made in satoshi for example.

Comission percent is hardcoded in env, in real app it would be better to have it configurable (store default value in env and populate it to config and replace it if corresponding DB value presented).

As we use minimal amounts of money for calculations, comissions are calculated with ceil as we want to round to bigger nearest non-float value.

Auth may be created with OAuth, JWT, Bearer, 3rd party or custom. Didn't implement in in the scope of the task.

Return values of Resolver and most of the functions should be DTO's, VO's or Collections and should be added to return type of functions. For prod would be good to have Typed collections that will have similar objects.

For transactions tracking and managing it may be appropriate to use event sourcing to be able to reproduce app state at each moment of time, have clear understanding what changes were made and have an ability to rollback all actions if needed.

Xdebug was added for tracing purposes, on prod env. it should be disabled

