#RabbitMQ Example with PHP

##Structure code
```
|config
|-- env.php
|runtime
|-- cache
|------ config.php
|src
|-- consumer
|------ worker.php
|-- producer
|------ sender.php
|.env.example
|build.php
|composer.json
|composer.lock
|README.md
```

##Setup

Follow by three main steps:

- Run `composer install`
- Rename `.env.example` file to `.env`(should copy to new file) and update config for `.env`
- Run command `php build.php` to generate config

## Run app

- Run consumer first: `php src/consumer/worker.php`
- Run producer second: `php src/producer/sender.php`


