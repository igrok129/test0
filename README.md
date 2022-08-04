### Task
1. Develop a RESTful API for displaying, storing, updating and deleting PhoneBook entries.
2. An entry in the PhoneBook must have the following fields:
   - Name
   - Surname
   - Telephone number (in E.164 recommendation format)
   - Country code (data for validation in file)
   - Timezone (data for validation in file)
   - Date and time of creation
   - Date and time of update
3. For each insert and update, a request should be sent to obtain country codes and time zones for further validation of the input data. In case of incorrect input, the application should return the appropriate error.
4. Exceptions must be handed properly, especially validation and exceptions during HTTP requests.
5. Application layers must by properly separated.
6. Appropriate design patterns should be used where it's applicable.
7. You need to display records in a list, as well as search by Id and by parts of full name.

------------

### Run project

You will need docker and docker-compose in order to run that.

1. Clone project - git@github.com:igrok129/test0.git .
2. Execute command in root of project - make run (it set up everything and run tests)

Project will be available at localhost:8080

------------

### Documentation
**Get list of PhoneBook entries.**
###### GET /v1/phone-book
**Params:**

| name        | type   | description           | required |
|-------------|--------|-----------------------|----------|
| id          | int    | filter by id          | no       |
| name        | string | filter by name        | no       |
| second_name | string | filter by second_name | no       |

**Response example:**
```json
[
    {
        "id": 1,
        "name": "first name",
        "second_name": "second name",
        "phone_number": "+14242432089"
    }
]
```

**Successful server response status code:** 200

------------

**Store entry in PhoneBook**
###### POST /v1/phone-book
**Params:**

| name         | type   | description                                                  | required |
|--------------|--------|--------------------------------------------------------------|----------|
| name         | string | name of owner                                                | yes      |
| second_name  | string | second_name of owner                                         | no       |
| phone_number | string | phone_number in E.164 format                                 | yes      |
| country_code | string | ISO 3166-1 alpha-2 (cca2) format or official name of country | no       |
| timezone     | string | timezone of country                                          | no       |

**Response example:**
```json
{
    "status": "success"
}
```

**Successful server response status code:** 201

------------

**Get specific entry from PhoneBook**
###### GET /v1/phone-book/{phone-book-entry-id}
**Params:**

| name                | type | description              | required |
|---------------------|------|--------------------------|----------|
| phone-book-entry-id | int  | entry, that we wanna get | yes      |

**Response example:**
```json
{
   "id": 1,
   "name": "first name",
   "second_name": "second name",
   "phone_number": "+14242432089",
   "country_code": "GE",
   "timezone": "Pacific/Niue",
   "created_at": "2022-08-04T08:50:38.000000Z",
   "updated_at": "2022-08-04T08:50:38.000000Z"
}
```

**Successful server response status code:** 200

------------

**Update specific entry from PhoneBook**
###### PUT|PATCH /v1/phone-book/{phone-book-entry-id}
**Params:**

| name                | type   | description                                                  | required |
|---------------------|--------|--------------------------------------------------------------|----------|
| phone-book-entry-id | int    | entry, that we wanna update                                  | yes      |
| name                | string | name of owner                                                | no       |
| second_name         | string | second_name of owner                                         | no       |
| phone_number        | string | phone_number in E.164 format                                 | no       |
| country_code        | string | ISO 3166-1 alpha-2 (cca2) format or official name of country | no       |
| timezone            | string | timezone of country                                          | no       |

**Response example:**
```json
{
   "id": 1,
   "name": "first name",
   "second_name": "second name",
   "phone_number": "+14242432089",
   "country_code": "GE",
   "timezone": "Pacific/Niue",
   "created_at": "2022-08-04T08:50:38.000000Z",
   "updated_at": "2022-08-04T08:50:38.000000Z"
}
```

**Successful server response status:** 200

------------

**Delete specific entry from PhoneBook**
###### DELETE /v1/phone-book/{phone-book-entry-id}
**Params:**

| name                | type   | description                 | required |
|---------------------|--------|-----------------------------|----------|
| phone-book-entry-id | int    | entry, that we wanna delete | yes      |

**Response example:** empty body

**Successful server response status:** 204