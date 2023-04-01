# Target
Enable users to set page targeting rules for a simple JS alert function.

[![Actions Status](https://github.com/lavendar77/target/workflows/Fly-Deploy/badge.svg)](https://github.com/lavendar77/target/actions)

![image](/public/demo.png)

## Database Design
https://dbdiagram.io/d/64281cd05758ac5f1725ed05

## Local Development
- Clone the repository
- Run `composer install`
- Run `composer run-script post-root-package-install` to duplicate the `.env.example` into `.env`
- Run `composer run-script post-create-project-cmd` to generate your application key
- Set up your local database and update the `.env` file
- Run your migrations with `php artisan migrate`
- Run `yarn install`
- Run `yarn dev`
