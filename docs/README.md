# PHP, Symfony, Doctrine : comprendre les migrations

En équipe de 2 développeurs, suivez les consignes en choisissant chacun votre rôle !  
Colonne de gauche, Tic et colonne de droite, Tac.

🌰 🌰 🌰
{: .text-center }

Cet atelier va t'apprendre à créer des entités et les utiliser grâce à Doctrine.

Vous allez récupérer un repo dans lequel se trouve un affichage **(que vous n'aurez pas à modifier)** prévu pour lister les écureuils ayant accès au stock de noix, ainsi que le stock juste en dessous. (_Vous vous en doutez, pour le moment c'est vide_ 😏)  
Votre but sera donc de créer les entités nécessaires à cet affichage, et pour cela, utiliser Doctrine !

## 👀 Tic
Sois attentif à ce que fait **Tac** et aide-le si besoin.

## Tac
### Initialisation du projet

Vous allez avoir besoin d'un projet Symfony, tu vas donc en créer un !

1.  Sur ton compte Github, crée un nouveau dépôt vide (sans fichier README.md) qui vous servira pour cet atelier
2.  Clone ce dépôt grâce au lien donné ci-dessus ⬆ <a href="#input-clone"><i class="bi bi-code-slash"></i>&nbsp;Code</a>.
3.  Change l'Url du dépôt par celui que tu viens de créer en utilisant `git remote set-url origin [l'adresse de ton nouveau dépôt]`
4.  Envoie le projet sur ton dépôt et donne le lien à Tic

## Tic
Clone le projet en local sur ta machine grâce au lien fourni par Tac.

## 👀 Tac
Sois attentif à ce que fait **Tac** et aide-le si besoin.

# Tous les deux

Maintenant que vous avez tous les deux le projet, exécutez les commandes suivantes dans le terminal :
```bash
composer install
yarn install
```
Puis configurez votre fichier `.env.local` en renseignant vos identifiants mySQL et le nom de votre base de données afin d'initier la connexion.  
Créez ensuite votre base de données en exécutant la commande suivante dans le terminal 
```bash
symfony console doctrine:database:create
```  
  
Tout au long de cet atelier, vous appliquerez les bonnes pratiques acquises jusqu'ici, à savoir créer des branches pour chaque étape et faire des Pull Requests.
{: .alert-info }

## 👀 Tic
Aide Tac à créer sa première entité

## Tac
### Crée ta première entité

Tu vas créer ta première entité afin de gérer les écureuils ayant accès au stock de noix.

1.  Crée une entité `Squirrel` avec la commande 
```bash
symfony console make:entity
```
2.  Remplis tous les champs nécessaires à la création de ton entité, à savoir `name (VARCHAR(100) NOT NULL)`
3.  Bravo, tu viens de créer ta première entité ! Tu peux envoyer ton travail sur le repo pour que Tic le récupère

## Tic
### Ajoute des écureuils dans ta base de données

Parfait, Tac a crée l'entité `Squirrel`, tu vas pouvoir ajouter la table à ta base de données !

1.  Récupère les dernières modifications avec un `git pull`
2.  Exécute les modifications dans ta base de données en faisant 
```bash
symfony console doctrine:migrations:migrate
```

  
À ta plus grande surprise, cela ne fonctionne pas, tu obtiens ce message d'erreur : ![](images/error1.png)  
Mince ! Tac a omis une étape lors de la création de son entité !  
Après lui avoir évidemment fait remarquer, tu lui suggères de taper dans son terminal
```bash
symfony console make:migration
```  
  
Cela va permettre de générer le fichier qui, une fois exécuté à l'aide de ta précédente commande, crééra une table `Squirrel` dans ta base de données  
  
Une fois cela fait et son travail à nouveau push sur le repo, tu peux le récupérer et exécuter à nouveau 
```bash
symfony console doctrine:migrations:migrate
```

## 👀 Tac
### Observation

Sois attentif à ce que fait 🐿 Tic et aide-le si besoin.  

* * *

Comme te l'a fait remarquer Tic, il manque une étape à réaliser après la création de ton entité ! Il faut créer un fichier de migration afin d'envoyer les informations en base de données.  
  
Un fois cela fait, pousse de nouveau ton travail sur le repo pour que Tic récupère ce fichier.  
N'oublie pas d'exécuter toi aussi la commande 
```bash
symfony console doctrine:migrations:migrate
```

# Tous les deux

Il faut bien retenir qu'après avoir créé une nouvelle entité, il faut générer un fichier de migration, puis l'exécuter afin de répercuter les modifications en base de données. Par ailleurs, il est indispensable également de supprimer puis recréer la base de données à chaque changement de branche/pull de la branche distante afin de répercuter les modifications apportées à cette dernière.  
  
Les étapes à respecter sont donc les suivantes :  
  

Création d'une entité
1.  ```php
symfony console make:entity
//symfony console m:e
```
2.  ```php
symfony console make:migration
//symfony console m:mig
```

  
Synchroniser la structure d'une base de données :

1.  Destruction de la BDD 
```php
symfony console doctrine:database:drop --force
//symfony console d:d:d -f
```
2.  Création de la BDD
```php
symfony console doctrine:database:create
//symfony console d:d:c
```
3.  Mise à jour de la structure de la BDD
```php
symfony console doctrine:migrations:migrate
//symfony console d:m:m
```

Parfait, vous avez tous les deux une entité Squirrel, mais ce n'est pas pour autant que vous avez des écureuils dans votre base de données ! Et pas de panique, vous avez supprimé votre base de données mais vous allez maintenant y insérer des données grâce aux fixtures !

## 👀 Tic
Sois attentif à ce que fait **Tac** et aide-le si besoin.

## Tac
### Remplis ta base de données grâce aux fixtures

Les fixtures te permettent de générer des fausses données afin de pouvoir tester ton site en développement avec du contenu, sans avoir à rentrer des données manuellement à chaque rechargement de ta base de données.  
  

1.  Commence par installer la dépendance permettant de créer des fixtures
```bash
composer require --dev orm-fixtures
```
2.  Crée ensuite ta classe de fixtures pour les écureuils à l'aide de la commande suivante
 ```bash
 symfony console make:fixtures
 ```
 Pour plus de lisibilité et par logique, tu l'appeleras `SquirrelFixtures`.
3.  Maintenant que ta classe de fixtures est créée, tu vas ajouter des instructions pour créer tes données, tu peux t'inspirer du code ci-dessous
```php
public function load(ObjectManager $manager)
{
        for ($i = 0; $i < 5; $i++) {
            $squirrel = new Squirrel();
            $squirrel->setName('name' . $i);
            $manager->persist($squirrel);
        }
        $manager->flush();
}
```

4.  Parfait ! Tu peux maintenant lancer la génération de tes fixtures avec la commande
 ```bash
 symfony console doctrine:fixtures:load
 ```
5.  Modifie la méthode index dans le *HomeController* afin d'envoyer à ta vue `home/index.html.twig` ta liste d'écureuils, puis vérifie que tu les affiche bien.  
Formidable ! Tu as créé des données pour ton entité Squirrel ! N'oublie pas d'envoyer ton travail sur le repo afin que Tic puisse s'en servir également.

## Tic
### Création du stock de noix

Avant d'aller plus loin, il faut que tu récupères ce que viens de faire Tac. Puisqu'il a *push* son travail, c'est très facile 😉. 

Mais n'oublie-pas ce que nous avons vu précédement : <a href="#tous-les-deux-1">synchroniser la BDD</a> !
{: .alert-info }

Et ce n'est pas la seule précaution à prendre. Une nouvelle dépendance a été installée par Tac, `orm-fixtures`. Il te faut donc également mettre ton application à jour avec la commande :
```bash
composer install
```

----

Maintenant que vous pouvez lister qui a accès à votre stock de noix, il faudrait y ajouter des éléments afin de le remplir un peu.  
En t'appuyant sur ce que Tac a fait jusqu'ici :

1.  Crée une entité `Nut` avec les champs nécessaires `name (VARCHAR(100) NOT NULL), stock (INT)`
2.  Génère le fichier de migration puis exécute-le
3.  Crée des fixtures pour remplir ton stock de noix, mais de manière plus réalistes que pour les écureuils, par exemple avec ceci :
    ```php
    public const NUTS = [
        ['name' => 'Noix', 'stock' => 129],
        ['name' => 'Noisette', 'stock' => 364],
        ['name' => 'Amande', 'stock' => 53],
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::NUTS as $nut) {
            $newNut = new Nut();
            $newNut->setName($nut['name']);
            $newNut->setStock($nut['stock']);
            $manager->persist($newNut);
        }
        $manager->flush();
    }
    ```

1.  Une fois cela fait, lance la commande permettant de générer les fixtures
2.  Modifie la méthode *index* dans le *HomeController* afin d'envoyer à ta vue `home/index.html.twig` ton stock de noix, puis vérifie que tu les affiche bien.
3.  Fais un push sur le repo afin que Tac puisse récupérer ce que tu viens de faire

## 👀 Tac
Sois attentif à ce que fait **Tic** et aide-le si besoin.

Une fois que Tic aura fini et envoyé son travail, récupère-le et exécute les migrations comme vu précédemment afin d'afficher les écureuils et le stock sur ta page.

# Bravo !

Si tout a fonctionné jusqu'ici, vous devez afficher la même chose sur votre page index chacun de votre côté, vous avez dompté Doctrine (pour le moment 😈)
{: .text-center }

![](https://c.tenor.com/BLF9MvMHYXwAAAAC/drinks-drinking.gif)
{: .text-center }