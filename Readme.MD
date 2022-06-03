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

Ajout du script "run-server" dans composer.json

    "scripts": {
        "run-server": [
            "Composer\\Config::disableProcessTimeout",
            "php -d display_errors -S localhost:8000 -t public/"
        ],
        "test:cs": [
            "php vendor/bin/php-cs-fixer fix --dry-run --diff"
        ],

        "fix:cs": [
            "php vendor/bin/php-cs-fixer fix"
        ]
    }

On peut maintenant démarrer le serveur local avec composer.

### III. Commentaire

Affichage graphique de l'ajout de séries non implémenté mais les fonctions nécessaires ont été crées ans la classe TvShow.