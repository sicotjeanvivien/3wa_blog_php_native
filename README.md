# BLOG EN PHP NATIVE

Le but de l'exercice est de mettre en place une structure d'application respectant le disgnPattern MVC via un blog. Nous allons mettre en place :
    - un router permattant de gérer les pages via les URL
    - une authentification permettant aux utilisateur de se connecter
    - CRUD d'article permattant de gérer les données
    - une gestion de formulaire 
  

## ETAPE 1 : ROUTER

Nous allons commencer notre projet par la mise en place du router. Le router permet d'éxecuter le contrôleur lié à une URL, pour renvoyer la vue/template demandé par le client.

### Indications : 
  
Le projet se compose de 4 répertoires principaux :
  - lib => correspond aux fonctionnalités de notre application
  - public => correspond à la porte d'entrée de notre application; le nom de domaine cible directement ce répertoire; cela permet de limité l'accés des utiloisateurs aux fichiers de l'application
  - src => partie logique de notre application; utilise les fonctionnalités stockées dans le lib;
  - template => correspond aux vue/template de notre application
Le router est déjà mis en place.
Pour lancer le server, il faut se mettre via le terminal dans le répertoire racine de projet le utiliser la commande "php -S localhost:8000 -t public/".
La page home est accessible via l'url "http://localhost:8000/"
Attention pour accéder aux différentes page, il faut utilisé "http://localhost:8000/?page=nom_page"

### Consignes :

Mise en place d'une nouvelle page. Sur le même modèle que la page "home" créer une nouvelle page nommée "contact". Il faudra penser :
  - à ajouter la route dans la constante ROUTING
  - créer un nouveau controller "ContactController"
  - créer le template dans template/contact/contact_base.phtml
  - Passer en paramètre dans la methode renderView(), un tableau params avec pour clé "message" et en valeur "hello world"
  - Afficher le message sur la page "Contact"


## ETAPE 2 : HABILLAGE

Nous allons ajouter une navbar dans notre application pour faciliter la navigation. Nous allons aussi changer le backgroud-color. Nous allons pour finir ajouter un carrousel.
Vous n'êtes pas obligé d'utiliser bootstrap.

### Consignes :
###### NavBar
- Remplacer le contenu html /template/base.phtml par le template de base de bootstrap " 2. Include Bootstrap’s CSS and JS." (https://getbootstrap.com/docs/5.2/getting-started/introduction/) 
- créer /teemplate_part/__navbar.phtml, ajouter une navbar bootstrap (https://getbootstrap.com/docs/5.2/components/navbar/#nav). Attention, il faut nettoyer le code. 
- Dans /template/teemplate_part/__navbar.phtml, mettre en place des liens vers les deux pages de l'pplication
- Faire un include_once de "__navbar.phtml" dans /template/base.phtml
###### backgroud-color
- créer le fichier /public/css/main.css
- dans le fichier /public/css/main.css, ajouter la classe "backgroud-color : #bada55"
- lier le fichier /public/css/main.css avec le fichier template/base.phtml
###### carrousel
- récupérer 3 images au moins sur le site (https://pixabay.com/fr/)
- placer les images dans le dossier /public/img/
- créer un fichier /template/home/__carrousel.phtml
- récupérer le carrousel (https://getbootstrap.com/docs/5.2/components/carousel/#with-indicators)
- implémenter les imges dans le carrousel
- inclure le carrousel dans la page "HOME"


## ETAPE 3 : AFFICHER LES ARTICLES

En utilisant la base de donnéés du fichier base.sql, afficher les articles sur une nouvelle page nommée article. La mise en forme est libre, vous pouvez utiliser bootstrap.

### Consignes :
- créer la nouvelle page article, qui contient un titre "liste des  articles" et un table qui a pour colonne "id" "titre" "date de publication".
- dans le fichier lib/Repository/AbstractRepository.php, créer la class AbstractRepository ainsi
    - constante : 
      -  private const DATABASE_NAME = "mysql:host=localhost;port=3306;dbname=micro_framework";
      - private const DATABASE_USERNAME = "root";
      - private const DATABASE_PASSWORD = "root";
    - methode :
      - private function connect()
      - protected function executeQuery(string $query, string $class, array $params = [])
- Créer le fichier /src/Model/Article.php, qui est le model de la table article.
- Créer le fichier /src/Repository/ArticleRepository.php qui contient la classe enfant ArticleRepository de la class parent AbstractRepository
- Dans le fichier /src/Repository/ArticleRepository.php, créer une methode findAll() qui récupére tous les articles.
- Utiliser la methode findAll dans le ArticleController pour récupérer les articles et affiché les dans le table la page article.


## ETAPE 4 : CREATION USER

Nous allons créer un formulaire de création d'utilisateur avec hash du mot de passe et insertion dans la base de données.

### Consignes : 
  - créer la page user_add (user_add.phtml), avec son controller (UserController->add();)
  - créer un formulaire /template_part/__add_form.phtml pour créer un utilisateur dans la page user, faire un include dans la page user_add
  - créer le Model USER
  - créer le UserRepository
  - soumettre le formulaire user_add sur la même page que l'affichage du formulaire 
  - utilisé une condition avec $_POST pour exécuter le code d'insertion 
  - vérifier la validité des données et leurs existences 
  - vérifier que le username est unique à un utilisateur.
  - hash le mot de passe avec password_hash (algo: PASSWORD_BCRYPT option: ["cost" => 12]) 
  - Faire l'insert dans le fichier UserRepository. 
  - Créer le nouveau user via le model User.php 
  - Bonus : Faire un système d'erreur qui renvoie un message du style "Erreur: les informationsfournies ne sont pas valide." si les informations ne spont pas valide et " Utilisateur créer." si l'utilisateur est créé.



## ETAPE 5 : authentification

Nous allons mettre en place l'authentification des utilisateurs. 

### Consignes :
  - mettre en place la page user_connexion (UserController->connexion();) avec un formulaire de connexion usser_connexion.phtml (username, password)
  - dans le controller UserController->connexion() mettre en place l'authentification. Pour faire une authentification il faut d'abord récupérer l'utilisateur via son username avnt de vérifié avec la méthode php password_verify() la validité du mot de passe (https://www.php.net/manual/fr/function.password-verify.php)
  - Attention avent de vérifier le mot de passe vérifier que l'utilisateur existences
  - La page qui soumet le formulaire est la même qui affiche la vue 
  - la connection se fait via la variable globale $_SESSION. Si l'utilisateur a donnée des informations correcte créer $_SESSION["user_is_cennected"] = true; Attention pour pouvoir utiliser le $_SESSION, il faut initialiser le session avec la methode session_start(), pour plus de simplisité le placer au début du fichier public/index.php
  - Afficher dans la navbar un lien se connecter qui renvoie sur la page de connection si aucun utilisateur n'est connecter et un lien de deconnection si l'utilisateur est connecter. Pour déconnecter un utilisateur on détruit son token de session unset($_SESSION["user_is_connected"])
  - pour faire une redirection on utilise header("Location: nom_route");
  - Bonus : Faire un système d'erreur qui renvoie un message du style "Erreur: l'utilisateur ou le mot de passe ne sont pas valide." si les informations ne spont pas valide et " Vous étes connecté." si l'utilisateur arrive à se connecter.


## ETAPE 6 : AFFICHAGE D'UN ARTICLE

Nous allons créer une page avec notre article en détail

### Consignes :
 - Créer la page article_show "article_show.phtml" de controller "ArticleController->show()"
 - Créer un bouton <a> dans une nouvelle colonne dans le tableau de la page Article  qui renvoie vers la page article_show avec pour paramètre d'url page=article_show et id=id_article
 - afficher le nom (lastname) et le prénom (firstname) du créateur de l'article 
 - afficher la date de publication de l'article
 - exemple "créé par Hubert Dupont le 02/12/1900"
 - afficher les categories lié à cet article exemple "#category2  #category1"
 - pour cela il faudra créer le model Category.php, CategoryRepository.php
 - requete SQL : 
   - SELECT id, name FROM category INNER JOIN article_category ON category.id = article_category.category_id WHERE article_category.article_id = 1;
   - SELECT * FROM article WHERE id = :id;
   - SELECT * FROM user WHERE id = :id ;
 - faire une mise en forme propre, utiliser bootstrap ou perso 


## ETAPE 7 : CREATION D'ARTICLE

Nous allons mettre en place la création d'article liée à l'utilisateur courant en y ajoutant une image
### Indications : 
 - exécuter directement la requete sql pour modifier la table article "ALTER TABLE article ADD file_path_image VARCHAR(255);"
 - penser à modifier le model /src/Model/Article.php
 - Information on ne sauvegarde jamais un fichier directement en base de données on sauvegarde le chemin d'accés.
 - tout file upload doit avoir son nom de fichier modifier 
 - pour soumettre un formulaire avec un input:file il faut utiliser "enctype="multipart/form-data"" dans la balise form
 - pour transmettre plusieurs option dans un select multiple il faut définir le name="categories[]"

### Consignes :
 - la page de création d'un article n'est accessible qu'au utilisateur connecter
 - Attention il faut bloquer l'accés à la page aux niveau de la page et au niveau du controller avec un redirecte vers la page home par exemple
 - le bouton d'accés à la page de création d'article se trouve sur la page qui liste les articles
 - ajouter id lors de la connexion de l'utilisateur dans la session "$_SESSION['user_id'] = $user->getId();"
 - Créer le formulaire /template/article/template_part/__add_form.phtml
 - il comporte un titre (input, text, title), categories (select, multiple, categories ), contenu (textarea, content), image (input, file, image)
 - 

## ETAPE 8 : SUPPRESSION D'ARTICLE

Nous allons mettre en place la suppression d'article.
### Consignes


## ETAPE 9 : MODIFICATION D'ARTICLE

Nous allons mettre en place la modification d'article.
### Consignes


## ETAPE 10 : CATEGORY

Dans une nouvelle page, nous allons créer le CRUD pour les categories. Nous afficherons ensuite les categories dans une nouvelle colonne dans la page de la liste de nos articles.
### Consignes


## ETAPE 11 : COMMENTAIRE

Dans une nouvelle page, nous allons créer le CRUD pour les categories. Nous afficherons ensuite les categories dans une nouvelle colonne dans la page de la liste de nos articles.
### Consignes




