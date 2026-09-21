# SignalAyiti

Plateforme de signalement et de suivi des problèmes communautaires, pensée pour le
contexte de la vie quotidienne en Haïti : routes endommagées, coupures d'eau potable,
pannes d'électricité (EDH), déchets non ramassés, éclairage public défaillant et
problèmes de sécurité dans le quartier.

Projet réalisé dans le cadre du cours Développement Web, niveau approfondi (React +
Laravel).

## Le problème et la solution

Dans de nombreux quartiers haïtiens, les habitants observent au quotidien des
problèmes qui touchent leur vie de tous les jours, mais n'ont pas de moyen simple de
les faire remonter aux services communaux, ni de savoir si quelque chose a été fait.
SignalAyiti permet à un citoyen de signaler un problème en quelques champs, de suivre
son statut et d'être notifié dès qu'un agent communal intervient. L'agent, de son
côté, centralise tous les signalements et dispose d'un tableau de bord pour prioriser
son travail.

## Fonctionnalités principales

- Inscription et connexion (citoyens et agents communaux).
- Signalement d'un problème : catégorie, titre, description, quartier, photo facultative.
- Suivi du statut d'un signalement (nouveau, en cours, résolu, rejeté) avec historique des interventions.
- Ajout d'interventions par un agent (changement de statut avec commentaire).
- Notifications automatiques du citoyen à chaque changement de statut.
- Tableau de bord de statistiques (par statut, par catégorie, par quartier) pour les agents.

## Technologies

- **Front-end** : React (Vite), react-router-dom, Axios, Context API.
- **Back-end** : Laravel, Laravel Sanctum (authentification par token), Eloquent ORM.
- **Base de données** : SQLite (embarquée, aucun serveur séparé à installer).
- **Tests** : PHPUnit (backend).

## Structure du dépôt

```
SignalAyiti/
+-- backend/     API Laravel (migrations, modeles, controleurs, routes, tests)
+-- frontend/    Application React (pages, composants, appels API)
+-- docs/        Cahier des charges, conception visuelle, conception technique,
                  rapport final et slides de presentation
```

## Installation et lancement

Prérequis : PHP 8.3+, Composer, Node.js et npm.

### 1. Back-end (Laravel)

```bash
cd backend
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate --seed
php artisan storage:link
php artisan serve
```

L'API tourne sur `http://127.0.0.1:8000/api`.

### 2. Front-end (React)

Dans un second terminal :

```bash
cd frontend
npm install
cp .env.example .env
npm run dev
```

L'application est disponible sur `http://localhost:5173`.

### Comptes de démonstration (créés par le seed)

| Rôle    | Email                  | Mot de passe |
|---------|-------------------------|---------------|
| Agent   | agent@signalayiti.ht    | password      |
| Citoyen | citoyen@signalayiti.ht  | password      |

Un citoyen peut aussi simplement créer son propre compte depuis la page d'inscription.

## Tests

Tests backend (PHPUnit), sur l'authentification, la création de signalements et les
autorisations par rôle :

```bash
cd backend
php artisan test
```

Le parcours front-end a été vérifié manuellement (inscription, connexion, création
d'un signalement, changement de statut par un agent, réception de la notification par
le citoyen, consultation du tableau de bord).

## Documentation

Le dossier [docs](docs) contient :

1. Le cahier des charges (DSF).
2. Le dossier de conception visuelle (layout, wireframes, parcours utilisateurs).
3. Le dossier de conception technique (architecture, modèle de données, API, structure React).
4. Le support de présentation (slides, avec notes du présentateur).
5. Le rapport final, avec des captures d'écran commentées de l'application en fonctionnement.
