Supervygile
======

Inroduction
-----------

C'est un projet Symfony crée le 21 Mars 2018.
Le but de ce projet est de permettre la supervision de projets respectants la méthode agile.

Spécificités
--------------
- Creation de compte
- Creation de projet
- Rejoindre un projet
- Gestion de projet


Développement
-----------

Exécutez chaque commande ci dessous pour obtenir une copie du site web
- `git clone`
- `cd supervygile`

En supposant que php est dans votre Path
- `php composer install` - Fill in your database/smtp parameters
- `php bin/console cache:clear` - Clear cache
- `php bin/console doctrine:schema:update --force` - Initialize BDD
- `php bin/console doctrine:fixtures:load` - Fill BDD with fake datas
- `php bin/console assets:install --symlink` - Install vendor assets

En supposant que npm est dans votre path
- `npm i` - Install dependencies (Webpack and CKEditor5)
- `npm run build` - To build dependencies
