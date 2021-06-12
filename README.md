
# Matrix Developer Exam

This application is an example REST API to perform CRUD operations against a database. It is explicitly an example of code organization and the ability to implement all functionality without third party libraries (vanilla PHP), _not_ a production application.


## Connecting to the API

1. Determine base address of server running in Docker container
    ```
    $ ./server-address.sh 
    172.21.0.4
    ```

2. Query an API enpoint preceded by version string `1.0`
    ```
    $ curl --url "http://172.21.0.4/0.1/customer/phone/"
    GET PHONE
    ```


## Available endpoints

* `GET /0.1/customer/id_gov/51`
* `GET /0.1/customer/phone/51`
* `POST /0.1/customer`
* `PUT /0.1/customer/51`
* `DELETE /0.1/customer/51`


## Running with Docker

This application uses Docker Container to manage multiple containers.

### Build Steps

1. Build and start containers
    ```
    $ docker-compose up -d
    ```

2. Create and seed the database
    ```
    $ ./db-cli.sh
    mysql -h 172.18.0.3 -u root -p"" matrix

    $ mysql -h 172.18.0.3 -u root -p"" matrix < create_seed_database.sql
    ```
   

## Notes

* Deliberately not using dependency injection on classes. DI is very atypical on vanilla PHP projects not using a framework the encapsulates this (e.g. Laravel).


