# Portfolio Développeur Web - Symfony Expert

Un portfolio professionnel moderne et responsive développé avec Symfony 7, Bootstrap 5, et les dernières technologies web.

## 🚀 Fonctionnalités

### ✨ Design & Interface
- **Design moderne et responsive** avec Bootstrap 5
- **Animations fluides** avec AOS (Animate On Scroll)
- **Interface utilisateur intuitive** avec navigation fixe
- **Thème sombre/clair** adaptatif
- **Loading screen** avec animation CSS
- **Effets de parallaxe** et animations au scroll

### 🛠️ Technologies utilisées

#### Backend
- **Symfony 7.3** - Framework PHP moderne
- **PHP 8.2+** - Dernière version stable
- **Doctrine ORM** - Gestion des entités et base de données
- **MySQL 8.0** - Base de données relationnelle
- **Symfony Mailer** - Envoi d'emails professionnels

#### Frontend
- **HTML5** - Structure sémantique
- **CSS3** - Styles modernes avec variables CSS
- **JavaScript ES6+** - Interactivité avancée
- **Bootstrap 5.3** - Framework CSS responsive
- **Font Awesome 6** - Icônes vectorielles
- **Google Fonts** - Typographies modernes (Inter, JetBrains Mono)

#### Outils & Services
- **Docker** - Containerisation de l'application
- **Composer** - Gestion des dépendances PHP
- **NPM** - Gestion des packages JavaScript
- **Git** - Contrôle de version

### 📱 Sections du Portfolio

1. **Page d'accueil** - Hero section avec animation de code
2. **À propos** - Parcours, valeurs et témoignages
3. **Compétences** - Technologies maîtrisées avec barres de progression
4. **Projets** - Portfolio de réalisations avec filtres
5. **Contact** - Formulaire fonctionnel avec validation

### 🔧 Fonctionnalités techniques

- **Système de contact avancé** avec validation et templates email
- **Gestion des entités** (Projets, Compétences, Messages)
- **API REST** prête pour l'intégration
- **Système de filtres** pour les projets
- **Animations JavaScript** personnalisées
- **Responsive design** optimisé mobile-first
- **SEO friendly** avec meta tags appropriés

## 🏗️ Installation

### Prérequis
- Docker et Docker Compose
- PHP 8.2+
- Composer
- Node.js et NPM

### 1. Cloner le projet
```bash
git clone [url-du-repo]
cd portfolio-symfony
```

### 2. Configuration Docker
```bash
# Démarrer les services
docker-compose up -d

# Installer les dépendances PHP
docker-compose exec php composer install

# Configurer la base de données
docker-compose exec php php bin/console doctrine:database:create
docker-compose exec php php bin/console doctrine:migrations:migrate
```

### 3. Configuration des variables d'environnement
Créez un fichier `.env.local` :
```env
# Base de données
DATABASE_URL="mysql://symfony:azerty@database:3306/base_symfony?serverVersion=8.0&charset=utf8mb4"

# Mailer (pour le développement)
MAILER_DSN=smtp://localhost:1025

# Email d'administration
ADMIN_EMAIL=votre-email@exemple.com
```

### 4. Accès à l'application
- **Portfolio** : http://localhost:8080
- **phpMyAdmin** : http://localhost:8081
- **MailHog** : http://localhost:8025

## 📁 Structure du projet

```
portfolio-symfony/
├── app/
│   ├── config/          # Configuration Symfony
│   ├── public/          # Point d'entrée web
│   ├── src/
│   │   ├── Controller/  # Contrôleurs
│   │   ├── Entity/      # Entités Doctrine
│   │   ├── Repository/  # Repositories
│   │   └── Service/     # Services métier
│   ├── templates/       # Templates Twig
│   └── var/            # Cache et logs
├── apache/             # Configuration Apache
├── php/                # Configuration PHP
└── docker-compose.yaml # Services Docker
```

## 🎨 Personnalisation

### Modifier les informations personnelles
1. Éditez le contrôleur `MainController.php`
2. Modifiez les variables dans les méthodes des contrôleurs
3. Personnalisez les templates Twig

### Ajouter des projets
1. Utilisez l'interface d'administration ou ajoutez directement en base
2. Les projets sont gérés par l'entité `Project`
3. Utilisez les repositories pour les requêtes personnalisées

### Modifier le design
1. Éditez les styles CSS dans `base.html.twig`
2. Personnalisez les variables CSS dans `:root`
3. Modifiez les templates Twig selon vos besoins

## 🚀 Déploiement

### Production
1. Configurez les variables d'environnement pour la production
2. Optimisez les assets avec `composer dump-env prod`
3. Configurez un serveur web (Apache/Nginx)
4. Configurez un service SMTP pour les emails

### Hébergement recommandé
- **Heroku** - Déploiement simple avec Docker
- **DigitalOcean** - VPS avec Docker
- **AWS/GCP** - Cloud avec conteneurs
- **OVH** - Hébergement mutualisé compatible Symfony

## 📊 Performance

- **Optimisations CSS/JS** - Minification et compression
- **Cache Symfony** - Cache HTTP et application
- **Images optimisées** - Formats modernes (WebP)
- **CDN** - Distribution de contenu statique
- **Base de données** - Index et requêtes optimisées

## 🔒 Sécurité

- **Validation des données** - Sanitisation des entrées
- **Protection CSRF** - Tokens de sécurité
- **Headers de sécurité** - Configuration Apache/Nginx
- **Gestion des emails** - Protection contre le spam
- **Logs de sécurité** - Monitoring des accès

## 📈 Évolutions possibles

- **Blog intégré** - Articles et actualités
- **Système de commentaires** - Interaction avec les visiteurs
- **Multi-langue** - Support international
- **Dashboard admin** - Interface de gestion
- **API REST complète** - Intégration avec des applications tierces
- **PWA** - Application web progressive
- **Tests automatisés** - PHPUnit et Cypress

## 🤝 Contribution

1. Fork le projet
2. Créez une branche feature (`git checkout -b feature/nouvelle-fonctionnalite`)
3. Committez vos changements (`git commit -m 'Ajout nouvelle fonctionnalité'`)
4. Push vers la branche (`git push origin feature/nouvelle-fonctionnalite`)
5. Ouvrez une Pull Request

## 📝 Licence

Ce projet est sous licence MIT. Voir le fichier `LICENSE` pour plus de détails.

## 👨‍💻 Développeur

**Portfolio développé avec ❤️ par un développeur passionné**

- **Spécialisations** : Symfony, React.js, PHP, JavaScript
- **Expérience** : 5+ ans en développement web
- **Localisation** : France
- **Contact** : [Votre email]

---

*Fait avec Symfony 7, Bootstrap 5 et beaucoup de café ☕*
