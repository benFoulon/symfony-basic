# Symfony basic

Ce projet permet de se faire la main avec symfony.

## BDD

Utilisateur: 
- nom
- prénom
- email
- type : élèves, profs, clients

Projet: 
- nom
- description
- (utilisateurs)

Promo 
- Nom (une personnalité)
- date de début
- date de fin
- type de formation
- lieu 


## - créer l'utilisateur de la BDD
Comme pour tous le reste des commande nous allon utilisé 'php bin/console'

pour creer un utilisateur : on utilise le makerBundle (bundle communautaire) :
php bin/console make:user

## - créer la BDD
Cette fois on utilise l'ORM doctrine.
Il faut d'abord creer et configurer le fichier .env.local avec les infos de la base de donnée (username:mdp@localhost/..):
php bin/console doctrine:database:create

## - créer la structure de la BDD
Encore une fois on utilise doctrine 

php bin/console make:entity

qui vva nous permettre de creer des table(ou entité) que l'on pourra injecter a notre base de donnée en creant une migration 

php bin/console make:migration 
php bin/console doctrine:migration:migrate

enfin utiliseer 
php bin/console doctrine:schema:validate
pour s'assurer le bon mappage des entité

## - Donnés de test
Pour cela il faut creer des fixtures : 
php bin/console make:fixtures (cf. datafixtures)
et enfin les charger :
php bin/console fixtures:load
(ou voir le script dofilo.sh)

## - Lancer le server web
pour voir le resultat de nos fixtures il faut démarrer le server web en utilisant: 
symfony server:start
## - L'url à ouvrir pour tester les requete 
L'url d'accès nous est donnée dans le resultat de la commande précedente