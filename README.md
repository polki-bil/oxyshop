Aplikace beží jako klasické symfony s použitím symfony serveru, stačí tedy spustit:

symfony:server:start

DB má klasickou doctrine migraci takže stačí v .env přidat cestu k DB a spustit

doctrine:migrations:migrate

v .env pro jednoduchost je mozne mit sqlite databazi
DATABASE_URL="sqlite:///%kernel.project_dir%/var/database.db"

Endpointy jsou definovane v config/routes.yaml