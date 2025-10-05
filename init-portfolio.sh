#!/bin/bash

# Script d'initialisation du portfolio Symfony
echo "🚀 Initialisation du Portfolio Symfony..."

# Vérifier que Docker est en cours d'exécution
if ! docker-compose ps | grep -q "Up"; then
    echo "❌ Docker n'est pas en cours d'exécution. Démarrage des services..."
    docker-compose up -d
    echo "⏳ Attente du démarrage des services..."
    sleep 10
fi

# Aller dans le répertoire de l'application
cd app

echo "📦 Installation des dépendances..."
docker-compose exec php composer install --no-dev --optimize-autoloader

echo "🗄️ Création de la base de données..."
docker-compose exec php php bin/console doctrine:database:create --if-not-exists

echo "📋 Exécution des migrations..."
docker-compose exec php php bin/console doctrine:migrations:migrate --no-interaction

echo "🌱 Chargement des données de démonstration..."
docker-compose exec php php bin/console doctrine:fixtures:load --no-interaction

echo "🧹 Nettoyage du cache..."
docker-compose exec php php bin/console cache:clear

echo "✅ Portfolio initialisé avec succès !"
echo ""
echo "🌐 Accès à l'application :"
echo "   - Portfolio : http://localhost:8080"
echo "   - phpMyAdmin : http://localhost:8081"
echo "   - MailHog : http://localhost:8025"
echo ""
echo "📧 Configuration email :"
echo "   - Pour le développement, les emails sont capturés par MailHog"
echo "   - Pour la production, configurez MAILER_DSN dans .env.local"
echo ""
echo "🎉 Votre portfolio est prêt !"
