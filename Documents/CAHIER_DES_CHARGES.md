# Cahier des charges

## Plateforme de gestion et affectation des projets

Stage août/septembre 2019

Société : ISOPROM à Le Havre

## Élaboré par

Abdessamad et Sofiane DERRAZ

## Sommaire

1. Description du projet
2. Étude de l’existant
2.1 Fonctionnement actuel
2.2 Contraintes de la solution actuelle
2.3 La solution proposée
3. Analyse des besoins
3.1 Objectifs globaux
3.2 Objectifs spécifiques
3.3 Identification des acteurs
4. Environnement de développement
5. Structure de l’application web

## 1. Description du projet

Le projet porte sur le développement d’une application web de gestion et d’affectation de projets au sein de la société ISOPROM.

La société ISOPROM souhaite une plateforme visant à améliorer le processus de gestion grâce à une planification des projets dans le temps, une organisation des tâches reliées à chaque projet, pour chaque personnel.

Lorsqu'un projet est achevé, il devra être validé par le responsable qui pourra consulter les détails.

## 2. Étude de l’existant

### 2.1 Fonctionnement actuel

Après avoir étudié le fonctionnement actuel de la gestion des projets dans la société, on a pu avoir une idée globale sur la problématique. La gestion des projets se déroule via une fiche Excel qui ne répond pas aux besoins spécifiques de l’entreprise.

### 2.2 Contraintes de la solution actuelle

- Aucun moyen de suivi et de gestion du temps
- Le personnel n’est pas informé en temps réel des tâches
- Le gérant n’est pas informé en temps réel des tâches accomplies par le personnel
- La circulation de l’information dans un temps raisonnable est compliquée
- Aucun outil de gestion du planning/projets/tâches

### 2.3 La solution proposée

Afin de répondre efficacement aux besoins de la société, nous proposons le développement d’une application web qui perfectionnera la communication et la gestion des projets au sein d'ISOPROM. La plateforme devra permettre la gestion des permissions accordées à chaque utilisateur en fonction de ses rôles attribués, avoir un suivi des différents projets, taches et personnels internes de la société.

## 3. Analyse des besoins

### 3.1 Objectifs globaux

La plateforme doit répondre en premier lieu au besoin principal de la société et de ses personnels. C'est-à-dire le suivi de la réalisation des projets dont travaille une équipe de personnes qui représentent les employés de la société. L'outil ce devra être intuitif, ergonomique et sobre avec des fonctionnalités déterminées pour chaque type d'utilisateurs.

Une traçabilité et un rapport en fin de chaque projet sont indispensables.

### 3.2 Objectifs spécifiques

#### Installation

Lors de la première authentification, le premier utilisateur enregistré sera l’administrateur de l’application.

#### Authentification

L’accès à la plateforme doit être sécurisé par une adresse email et un mot de passe.

#### Permissions

Chaque utilisateur aura des permissions spécifiques à son rôle.

#### Gestion des clients

Les clients sont ajoutés, modifiés ou supprimés par le gérant de la société ou l’administrateur.

#### Gestion des Projets

L’ajout des projets pourra être effectué par l'administrateur, le gérant ou le chef de projet à partir d’un formulaire déterminant :

> - L’intitulé du projet
> - Description
> - Client
> - Date limite
> - Déplacement
> - Tâches
> - Chef de projet
> - Commentaire

Le chef de projet ou le gérant pourront ajouter des *tâches et les attribuer aux employés sélectionnés à partir d’un formulaire déterminant :

> - Description
> - Date de création
> - Date limite
> - Intervenant
> - Déroulement (%)
> - Commentaire

- Une discussion entre personnels concernant une tache doit être accessible dans la plateforme.
- L'état d'une tache par défaut est "en-cours". Elle peut être modifiée par l’employé à état fini, puis validé (ou invalidé) par le chef de projet.
- La date du début d'une tache est spécifiée lorsqu'elle est enclenchée
- La date de fin d'une tache est automatiquement spécifiée par la date actuelle lorsqu'elle est finie
- Un projet peut être clôturé par le gérant ou l’administrateur.
- Le déroulement d’une tache peut être modifié par le chef de projet en modifiant le pourcentage.
- La date de fin de la dernière tache (tache finale) représente la date de fin du projet.
- Un calendrier de projets sera accessible à tous les utilisateurs.
- Le rapport de chaque projet doit pouvoir être généré et exporté sous format PDF par l'administrateur, le gérant et le chef de Projet.

### 3.3 Identifications des acteurs

#### Les permissions selon les rôles seront

**Admin** à toutes les permissions

**Gérant** ou directeur général de la société pourra

- Accéder à la liste des projets
- Visualiser le calendrier des projets.
- Ajouter des projets et spécifier le chef de projet.
- Visualiser le déroulement des projets et leurs tâches.
- Gérer les utilisateurs de la plateforme, leur attribuer ou retirer des rôles.
- Générer le Rapport d’un projet.

**Chef de projet** est responsable d’un projet dont travaille un nombre d’employés. Il pourra :

- Visualiser les projets
- Gérer les taches supervisées
- Visualiser le calendrier des projets.
- Générer le rapport d’un projet.

**Employé** à pour autorisation de

- Visualiser le calendrier des projets.
- Réceptionner et répondre aux demandes de ses supérieurs reçus à partir des notifications.
- Marquer les tâches accomplies

## 4. Environnement de développement

Le serveur utilisera les outils suivants :

- Apache
- PHP 7.3
- MariaDB 10.3
- WAMP
- Nodejs
- Composer

Le développement de cette plateforme sera effectué sous le Framework Laravel 6.0, avec le langage PHP, le langage de balises HTML et jQuery.

La structure et le design de la plateforme seront développés avec CSS et Bootstrap.
