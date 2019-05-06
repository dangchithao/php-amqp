# RabbitMQ Example with PHP

## Structure code
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

## Setup

Follow by three main steps:

- Run `composer install`
- Rename `.env.example` file to `.env`(should copy to new file) and update config for `.env`
- Create new folder `runtime/cache` same level with `config` folder
- Run command `php build.php` to generate config

## Run app

- Run consumer first: `php src/consumer/worker.php`
- Run producer second: `php src/producer/sender.php`

## Command sample
- Work queue part(Message acknowledgment): ` php sender.php "first message." && php sender.php "second message.." && php sender.php "third message..." && php sender.php "fourth message...." && php sender.php "fifth message....."`


