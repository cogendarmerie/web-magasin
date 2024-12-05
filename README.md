# Web Mag

Projet étudiant en 3ème année à l'IT-AKADEMY

## Prérequis

Vous devez disposez à minimas sur votre machine :
- Docker
- Un naviguateur internet
- Make **(Recommandé)**

## Usage

### Méthode 1 - Makefile (Recommandé)

Créer les containers docker, créer les tables dans la base de données et compile les fichiers CSS.

```shell
make build
make migrate
make open
```

#### Lancer les containers (Déjà compiler)

```shell
make run
```

#### Arrêter les containers

```shell
make stop
```

### Méthode 2 - Manuel

Construire les containers

```shell
docker compose up --build -d
```

> L'argument **-d** n'est pas obligatoire. Il permet de lancer les containers en arrière plan.

Compiler les fichiers CSS

```shell
docker exec -it mag_sass /bin/sh -c "sass ./assets/css/main.sass ./public/assets/css/main.css --no-source-map --style=compressed"
```

Construire les tables dans la base de donnée

```shell
docker exec -it mag_php /bin/bash -c "php migrate.php"
```

## Test unitaire

Pour vérifier que tous fonctionne, vous pouvez lancez les tests unitaire via la commande 

```shell
make test
```

## Accès

### Interface web

L'accès à l'interface web se fait via un naviguateur classique via le port 8080.

- Ouvrir un naviguateur internet, exemple Firefox
- Saisir `http://localhost:8080`

[Ouvrir dans le naviguateur par défault](http://localhost:8080)

> Un container **Phpmyadmin** est construit également pour administrer la base de donnée au besoin. Il est disponible sur le port **8081**. Les identifiants de connexion sont disponible dans le fichier **docker-compose.yml**.