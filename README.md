# SignalAyiti

Plateforme de signalement et de suivi des problemes communautaires, pensee pour le
contexte de la vie quotidienne en Haiti : routes endommagees, coupures d'eau potable,
pannes d'electricite (EDH), dechets non ramasses, eclairage public defaillant et
problemes de securite dans le quartier.

Projet realise dans le cadre du cours Developpement Web, niveau approfondi (React +
Laravel).

## Le probleme et la solution

Dans de nombreux quartiers haitiens, les habitants observent au quotidien des
problemes qui touchent leur vie de tous les jours, mais n'ont pas de moyen simple de
les faire remonter aux services communaux, ni de savoir si quelque chose a ete fait.
SignalAyiti permet a un citoyen de signaler un probleme en quelques champs, de suivre
son statut et d'etre notifie des qu'un agent communal intervient. L'agent, de son
cote, centralise tous les signalements et dispose d'un tableau de bord pour prioriser
son travail.

## Fonctionnalites principales

- Inscription et connexion (citoyens et agents communaux).
- Signalement d'un probleme : categorie, titre, description, quartier, photo facultative.
- Suivi du statut d'un signalement (nouveau, en cours, resolu, rejete) avec historique des interventions.
- Ajout d'interventions par un agent (changement de statut avec commentaire).
- Notifications automatiques du citoyen a chaque changement de statut.
- Tableau de bord de statistiques (par statut, par categorie, par quartier) pour les agents.

## Technologies

- **Front-end** : React (Vite), react-router-dom, Axios, Context API.
- **Back-end** : Laravel, Laravel Sanctum (authentification par token), Eloquent ORM.
- **Base de donnees** : SQLite (embarquee, aucun serveur separe a installer).
- **Tests** : PHPUnit (backend).

## Structure du depot

```
SignalAyiti/
+-- backend/     API Laravel (migrations, modeles, controleurs, routes, tests)
+-- frontend/    Application React (pages, composants, appels API)
+-- docs/        Cahier des charges, conception visuelle et conception technique
```

## Installation et lancement

Prerequis : PHP 8.3+, Composer, Node.js et npm.

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

### Comptes de demonstration (crees par le seed)

| Role    | Email                  | Mot de passe |
|---------|-------------------------|---------------|
| Agent   | agent@signalayiti.ht    | password      |
| Citoyen | citoyen@signalayiti.ht  | password      |

Un citoyen peut aussi simplement creer son propre compte depuis la page d'inscription.

## Tests

Tests backend (PHPUnit), sur l'authentification, la creation de signalements et les
autorisations par role :

```bash
cd backend
php artisan test
```

Le parcours front-end a ete verifie manuellement (inscription, connexion, creation
d'un signalement, changement de statut par un agent, reception de la notification par
le citoyen, consultation du tableau de bord).

## Documentation de conception

Le dossier [docs](docs) contient les trois livrables de conception redigees avant le
developpement :

1. Cahier des charges (DSF).
2. Dossier de conception visuelle (layout, wireframes, parcours utilisateurs).
3. Dossier de conception technique (architecture, modele de donnees, API, structure React).
