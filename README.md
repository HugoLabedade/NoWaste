# NoWaste 

1.  [Description du projet](##Description)

2.  [Liste des fonctionnalités](##Fonctionnalités)

    *   [Le site](###Le-site-se-composera-obligatoirement-des-pages-suivantes-:)
    *   [L'administration](###-L'administration-se-composera-obligatoirement-des-pages-suivantes-:)
    *   [Fonctionnalités](###Fonctionnalités-du-site-:)
        *   [Fonctionnalités Opérationnelles](####Fonctionnalités-Opérationnelles-à-ce-jour-:)
        *   [Fonctionnalités Non Opérationnelles](####Fonctionnalités-Non-Opérationnelles-à-ce-jour-:-(en-cours-de-développement))

3.  [Comment cloner le projet](##Cloner-le-projet)

## Description 

__Nowaste__ est une marque de textile de sport exclusivement en ligne qui permet de proposer des vêtements pour les sportifs, confectionnés uniquement à l’aide de matériaux issus du recyclage. Notre but, faire rentrer le textile dans une nouvelle ère, celle du recyclage.

_Comment les déchets sont convertis en vêtements ?_

Les déchets sont broyés en pétales puis mixés avec des bouteilles en plastique, ensuite le tout est mélangé et transformé en une masse liquide et enfin tissé en fil. Le fil est alors transformé en matière qui servira à la production de la collection.

Ce projet est à l'origne un projet de ydays auquel Benjamin Chancerel participe. Nous avons eu donc l'idée de développer le site de __Nowaste__.

## Fonctionnalités :

Notre groupe est composé de __Hugo Labedade__ et __Benjamin Chancerel__.

Notre projet consiste à développer un site web basé sur le e-commerce. Effectivement, pour un projet
personnel nous devons développer un site web pour une marque de vêtements de sport qui s’appelle
NoWaste.
Notre projet reprendra donc toutes les fonctionnalités décrites dans le pdf.

### Le site se composera obligatoirement des pages suivantes :
-   page d'accueil
-   page produit (description et avis)
-   page du panier d’achat
-   page d’espace client
-   page d’inscription / connexion

### L'administration se composera obligatoirement des pages suivantes :
-   page tableau de bord
-   page des membres
-   page des produits
-   page de connexion

### Fonctionnalités du site :

#### Fonctionnalités _Opérationnelles_ à ce jour :

-   Liste des articles 
-   Système de recherche
-   Création de compte/connexion (avec information sur le compte)
-   Page produit qui contient : __l'image__ de l'article / __le nom__ de l'article / __le prix__ de l'article / __les avis__ des acheteurs / __un bouton d’achat__ /

#### Fonctionnalités _Non Opérationnelles_ à ce jour : (en cours de développement)

-   un email automatique est envoyé à l’acheteur après la vente avec : la facture en pdf
-   un espace administrateur est mis en place avec une authentification
-   un tableau de bord est présent dans l’espace administrateur avec des informations tels que : nombre de membres / nombre de ventes / nombre de nouvelles ventes sur les 7 derniers jours / les revenus du site totaux / les revenus du site sur les 7 derniers jours
-   les administrateurs peuvent gérer les articles avec un CRUD

## Cloner le projet 

Tout d'abord vous devez installez __symfony__, __composer__, __nodeJS__ et __yarn__ aux adresses suivantes :

*   https://symfony.com/download
*   https://getcomposer.org/download/
*   https://nodejs.org/fr/download/
*   https://classic.yarnpkg.com/en/docs/install/#windows-stable

Vous devez également installer __XAMPP__ ou un équivalent(MAMMP par exemple)

Après avoir récupérer le projet sur git, et avoir lancer votre terminal dans le bon dossier. Vous faites les commandes suivantes :

```
composer require symfony/swiftmailer-bundle
composer require symfony/webpack-encore-bundle --dev
yarn install
yarn add @symfony/webpack-encore --dev
yarn add sass-loader@^9.0.1 node-sass --dev
npm uninstall node-sass
npm install node-sass@4.14.1
yarn encore dev
```

Créez la BDD avec les commandes (Changer le .env si besoin) :

```
symfony console doctrine:database:create
symfony console doctrine:migrations:migrate
```

Ensuite aller sur l'adresse suivante :


*   http://localhost:8080/phpmyadmin/

Cliquez sur la base de donnée nowaste qui vient d'être créée. Cliquez sur importer, et importez le fichier .sql qui se trouve dans le git.

Enfin lancer votre server avec la commande :
``symfony server:start``

Allez à cet url :
http://127.0.0.1:8000/debut

