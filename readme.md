<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

## Transactional email micro-service
This micro-service will use external services to actually sent the emails.
When such an external service is unavailable there should be a fallback to a secondary service.
- Able to send an e-mail by an (JSON) API and through a CLI command.
- Logging entry for every email that is sent.
- Using queuing technique for sending email asynchronously.
- The micro-service is horizontal scalable.
- The code has tests.
- Using docker for running.
- Including a VueJS application
    - which allows to send an email (using this service)
    - which allows to see all the emails with their status
- Allow multiple mail formats
    - HTML
    - Text
    
- For more information please visit [Wiki page](https://github.com/3ehrang/email-service-api/wiki)

## Techniques

- Laravel
- MySQL
- Redis
- VusJS
- Horizon
- Docker
- [Email Gateway](https://packagist.org/packages/beno/email-gateway)

## Installation

1. Clone project
2. Inside project's folder run `docker-compose up -d --build`
3. After your docker container comes up run `docker-compose exec bifrost bash ./docker/setup.sh` for setting up all necessary things
4. Put your email services information inside `config/gateways.php`

Now the project will be ready!

## Good to know

- Project main page: http://localhost:8000
- Access Laravel Horizon: http://localhost:8000/horizon/
- Access phpMyAdmin:  http://localhost:8081

## Api Endpoints

Actions Handled
 
| Verb | URI | Action | Route Name
| --- | --- | --- | --- |
| GET | `/api/emailservice/v1/emails` |List all **Received** emails | email.service.api.v1.emails.index
| POST | `/api/emailservice/v1/emails` |**Create** and **Send** email |  email.service.api.v1.emails.send

### Email Sending Request and Response

#### Request:

**contentType** could be: *"text/string"* or *"text/html"*

```json
{
    "subject":"Molestiae quidem ratione ipsum.",
    "from":"sender@example.com",
    "fromName":"Pietro Yost",
    "to":"receiver@example.com",
    "toName":"Lexi Kertzmann",
    "contentType":"text\/string",
    "content":"Rerum soluta culpa quia perspiciatis mollitia deserunt. Numquam et excepturi est nulla laboriosam.",
    "app_id":"support"
}
```

#### Response:

Status field could be: *success*, *fail* or *error* using [JSend](https://github.com/omniti-labs/jsend) fomat

```json
{
    "status": "success",
    "data": {
        "sid": "sid-5cfde4a17d652",
        "received": {
            "subject": "Molestiae quidem ratione ipsum.",
            "from": "sender@example.com",
            "fromName": "Pietro Yost",
            "to": "receiver@example.com",
            "toName": "Lexi Kertzmann",
            "content": "Rerum soluta culpa quia perspiciatis mollitia deserunt. Numquam et excepturi est nulla laboriosam.",
            "contentType": "text/string"
        }
    }
}
```

## Test

Run PHPUnit test in project foldr by this command:

`./vendor/bin/phpunit`
