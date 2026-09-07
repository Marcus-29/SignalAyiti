# SignalAyiti, API back-end (Laravel)

API REST du projet SignalAyiti, plateforme de signalement et de suivi des problemes
communautaires en Haiti. Voir le [README principal](../README.md) pour la presentation
complete du projet et les instructions d'installation globales.

## Demarrage rapide

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate --seed
php artisan storage:link
php artisan serve
```

L'API est alors disponible sur `http://127.0.0.1:8000/api`.

## Comptes de demonstration (apres le seed)

| Role    | Email                    | Mot de passe |
|---------|--------------------------|---------------|
| Agent   | agent@signalayiti.ht     | password      |
| Citoyen | citoyen@signalayiti.ht   | password      |

## Tests

```bash
php artisan test
```
