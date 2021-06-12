
# Matrix Developer Exam

This application is an example REST API to perform CRUD operations against a database. It is explicitly an example of code maintainability and the ability to implement all functionality without third party libraries (vanilla PHP), _not_ a production application.


## Connecting to the API

API endpoints can have optional per-endpoint authentication required, all configured endpoints require this authentication. Use a standard bearer authentication header with the following value: `XPwb94dZfCP1pWdYPzR9p19HBT85kYutAMY0csPDs3B1OkcChKCJhXQkZlrXLmOV`

1. Determine base address of server running in Docker container
    ```
    $ ./server-address.sh 
    172.21.0.4
    ```

2. Using the address from the previous step, query an API enpoint preceded by version string `1.0`
    ```
    $ curl --url "http://172.26.0.4/0.1/customer/phone/058-767-8311" -H "Authorization: Bearer XPwb94dZfCP1pWdYPzR9p19HBT85kYutAMY0csPDs3B1OkcChKCJhXQkZlrXLmOV"
    {"customers":[{"id":3,"id_gov":"317907003","name_first":"Rachel","name_last":"Sara","date_birth":"2013-09-29","sex":"female","phones":["058-767-8311","(972) 52-034-1936","054-776-9563 ex 13"]}]}
    ```


## Available endpoints

* `GET /0.1/customer/id/51`
* `GET /0.1/customer/id_gov/51`
* `GET /0.1/customer/phone/51`
* `POST /0.1/customer`
* `PUT /0.1/customer/51` JSON Body
* `DELETE /0.1/customer/51` JSON Body

### JSON Body Format

```
{
  "id_gov": "317907011",
  "name_first": "Noam",
  "name_last": "Orr",
  "date_birth": "2004-04-01",
  "sex": "female",
  "phones": [
    "054-232-7878",
    "(972) 52-123-4567",
    "04-531-1200 ex 42"
  ]
}
```

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

* Though PHP 8 offers many features that would have been helpful (e.g. `str_starts_with()`, union types, and static return types), this application is coding in PHP 7.4 as I've yet to see PHP 8 used in production anywhere.
* There is minimum error handling as this is not a production system but rather a demonstration.
* Emphasis is on correctness and maintainability, not performance. Once unit tests are written, the code can be optimized for performance.
* Deliberately not using dependency injection on classes. DI is very atypical on vanilla PHP projects not using a framework the encapsulates this (e.g. Laravel).
* Ideally, there should be a `sessions` database table providing for more secure API access by passing timestamped hashes of the API key instead of the key itself.
* The database field `date_birth` should be accompanied by a timezone field.
* The database field `id_gov` is a VARCHAR because some forms of ID may contain alphabetic characters or significant leading zeros in the unique identifier.
* The database field `phone_number` is a VARCHAR because phone numbers typically have significant leading zeros, may be expressed as alphabetic characters, and additionally may contain extension information.


