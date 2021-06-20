# BehatParallelExtension integration with symfony example


This example uses [BehatParallelExtension]  with behat extensions installed by comand

```
composer require --dev \
    behat/behat \
    friends-of-behat/mink \
    friends-of-behat/mink-extension \
    friends-of-behat/mink-browserkit-driver \
    friends-of-behat/symfony-extension \
    dmarynicz/behat-parallel-extension
```

## Configuration 

Example behat configuration is in  [behat.yml.dist](behat.yml.dist)

## Behat Bootstrap
In [tests/bootstrap.php](tests/bootstrap.php) you can find boostrap.php for [SymfonyExtension]

## Behat Contexts

In  [tests/Behat/Context](tests/Behat/Context) you can find Behat Contexts

### [DatabaseContext.php](tests/Behat/Context/DatabaseContext.php) 

This context on each scenario creates new empty database. 

### [ProductContext.php](tests/Behat/Context/ProductContext.php)

This context is for creating [Products](src/Entity/Product.php) in database.

### [TableContext.php](tests/Behat/Context/TableContext.php)

Assert the contents of the html table.

### [DemoContext.php](tests/Behat/Context/DemoContext.php)

[SymfonyExtension]  DemoContext  

### Installation

App requires [Composer 2.x] to install dependencies.

For more information about installing [Composer 2.x] please follow the documentation:
https://getcomposer.org/download/

#### Install dependencies

To install php packages you need to execute

```sh
composer install
```

### Executes tests

To Execute tests you need to run
```sh
composer tests
```

[//]: #
[Composer 2.x]: <https://getcomposer.org>
[BehatParallelExtension]: <https://github.com/Daniel-Marynicz/BehatParallelExtension>
[SymfonyExtension]: <https://github.com/FriendsOfBehat/SymfonyExtension>