# mes-elus-api

* Continuous Integration [![Build Status](https://travis-ci.org/smourph/mes-elus-api.svg?branch=master)](https://travis-ci.org/smourph/mes-elus-api)
* Test coverage [![codecov](https://codecov.io/gh/smourph/mes-elus-api/branch/master/graph/badge.svg)](https://codecov.io/gh/smourph/mes-elus-api)

## Useful commands

Composer update

```bash
docker-compose exec php composer update
```

PHPUnit

```bash
docker-compose exec php bin/phpunit
```

PHP-CS-Fixer

```bash
docker-compose exec php vendor/bin/php-cs-fixer fix --diff -v
```
