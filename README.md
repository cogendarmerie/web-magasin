# Web Mag

Projet étudiant en 3ème année à l'IT-AKADEMY

Par Corentin SAMARD--EYMONERIE

## Prérequis

Vous devez disposez à minimas sur votre machine :
- Docker
- Un naviguateur internet
- Make
- SASS

## Installation

### Docker

Construire les containers docker avec la commande :

```
docker compose up --build
```

### Base de donnée

Après avoir lancée Docker, se connecter au container php via le terminal :

```
docker exec -it mag_php /bin/bash
```

Puis dans le terminal :

```
php migrate.php
```

Ce fichier va venir créer toutes les tables dans la base de donnée.

### Makefile

Pour compiler les fichiers CSS, il est nécessaire de faire la commande :

```
make dev
```

## Accès

### Interface web

L'accès à l'interface web se fait via un naviguateur classique via le port 8080.

- Ouvrir un naviguateur internet, exemple Firefox
- Saisir `http://localhost:8080`

[Ouvrir dans le naviguateur par défault](http://localhost:8080)
