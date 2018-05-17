Cartel
======

Inroduction
-----------

This is a Symfony project started on November 25, 2016, 12:18 pm.
The goal is to provide a website for the "Cartel de l'IMT"

Specifications
--------------

- User Management
- Sports Managemet
- Pictures Sharing
- Events Management
- News System
- Easily customizable/Reusable

Development
-----------
Run every command below to get a working copy of the website
- `git clone`
- `cd cartel`

Assuming `php` is in your path
- `php composer install` - Fill in your database/smtp parameters
- `php bin/console cache:clear` - Clear cache
- `php bin/console doctrine:schema:update --force` - Initialize BDD
- `php bin/console doctrine:fixtures:load` - Fill BDD with fake datas
- `php bin/console assets:install --symlink` - Install vendor assets

Assuming `npm` is in your path
- `npm i` - Install dependencies (Webpack and CKEditor5)
- `npm run build` - To build dependencies

Cartel de l'IMT
===============

It is a Big worldwide sportive competition that last for 3 days beetween all IMT schools (Engineering schools)