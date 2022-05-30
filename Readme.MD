# Application web de consultation et modification de séries TV

## Membres du groupe : Elie Pouget "poug0007", Gabriel Houdry--Bohême "houd0012"

### I. Serveur Web local
Pour lancer le serveur web local : 

        php -d display_errors -S localhost:8000 -t public/ 

### II. Style de codage

Installation de php-cs-fixer.php renommé en .php-cs-fixer.php  
Execution des commandes :

    php vendor/bin/php-cs-fixer fix --dry-run
    php vendor/bin/php-cs-fixer fix --dry-run --diff
    php vendor/bin/php-cs-fixer fix

