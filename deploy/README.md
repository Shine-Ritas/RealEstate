# Laravel Livewire Docker Deployment

This directory contains all the configuration files needed to deploy your Laravel Livewire application using Docker.

## Directory Structure

```
deploy/
├── config/
│   ├── php/
│   │   ├── php.ini
│   │   └── php-fpm.conf
│   ├── nginx/
│   │   ├── nginx.conf
│   │   └── default.conf
│   ├── mysql/
│   │   └── my.cnf
│   ├── redis/
│   │   └── redis.conf
│   └── supervisor/
│       └── supervisord.conf
└── README.md
```

## Environment Variables

Create a `.env` file in your project root with the following variables:

```env
# Application
APP_NAME=Laravel
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=http://localhost

# Database
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=laravel
DB_PASSWORD=laravel_password
DB_ROOT_PASSWORD=root_password

# Redis
REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379

# Cache & Session
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis

# Mail
MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=hello@example.com
MAIL_FROM_NAME="${APP_NAME}"

# Logging
LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

# Broadcasting
BROADCAST_DRIVER=log

# Filesystem
FILESYSTEM_DISK=local

# Memcached
MEMCACHED_HOST=127.0.0.1

# AWS
AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

# Pusher
PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_HOST=
PUSHER_PORT=443
PUSHER_SCHEME=https
PUSHER_APP_CLUSTER=mt1

# Vite
VITE_APP_NAME="${APP_NAME}"
VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_HOST="${PUSHER_HOST}"
VITE_PUSHER_PORT="${PUSHER_PORT}"
VITE_PUSHER_SCHEME="${PUSHER_SCHEME}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"

# Docker Ports
NGINX_PORT=80
MYSQL_PORT=3306
REDIS_PORT=6379
MAILHOG_PORT=1025
MAILHOG_UI_PORT=8025
PHPMYADMIN_PORT=8080

# Telegram Bot (if using)
TELEGRAM_BOT_TOKEN=
TELEGRAM_BOT_USERNAME=
```

## Deployment Steps

1. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

2. **Build and Start Containers**
   ```bash
   docker-compose up -d --build
   ```

3. **Run Database Migrations**
   ```bash
   docker-compose exec app php artisan migrate
   ```

4. **Seed Database (if needed)**
   ```bash
   docker-compose exec app php artisan db:seed
   ```

5. **Set Proper Permissions**
   ```bash
   docker-compose exec app chown -R laravel:laravel /var/www/html/storage
   docker-compose exec app chown -R laravel:laravel /var/www/html/bootstrap/cache
   ```

6. **Clear and Cache Configuration**
   ```bash
   docker-compose exec app php artisan config:cache
   docker-compose exec app php artisan route:cache
   docker-compose exec app php artisan view:cache
   ```

## Services

- **Nginx**: Web server (Port 80)
- **PHP-FPM**: PHP application server
- **MySQL**: Database (Port 3306)
- **Redis**: Cache and session storage (Port 6379)
- **MailHog**: Email testing (Ports 1025, 8025)
- **phpMyAdmin**: Database management (Port 8080)

## Useful Commands

```bash
# View logs
docker-compose logs -f app
docker-compose logs -f nginx
docker-compose logs -f mysql
docker-compose logs -f redis

# Access containers
docker-compose exec app bash
docker-compose exec mysql mysql -u root -p
docker-compose exec redis redis-cli

# Stop all services
docker-compose down

# Stop and remove volumes
docker-compose down -v

# Rebuild specific service
docker-compose up -d --build app
```

## Configuration Files

### PHP Configuration
- `php.ini`: Main PHP configuration with optimized settings for Laravel
- `php-fpm.conf`: PHP-FPM pool configuration

### Nginx Configuration
- `nginx.conf`: Main Nginx configuration with security headers and gzip compression
- `default.conf`: Server block configuration for Laravel

### MySQL Configuration
- `my.cnf`: MySQL configuration optimized for Laravel applications

### Redis Configuration
- `redis.conf`: Redis configuration with persistence and memory management

### Supervisor Configuration
- `supervisord.conf`: Process management for PHP-FPM, queues, and scheduled tasks

## Security Considerations

1. Change default passwords in production
2. Use strong database passwords
3. Enable SSL/TLS in production
4. Configure proper firewall rules
5. Regularly update Docker images
6. Monitor logs for security issues

## Performance Optimization

1. Enable OPcache in PHP
2. Use Redis for caching and sessions
3. Configure proper MySQL settings
4. Enable gzip compression in Nginx
5. Use CDN for static assets in production
6. Monitor resource usage

## Troubleshooting

### Common Issues

1. **Permission Denied**: Run permission commands mentioned above
2. **Database Connection**: Check MySQL container status and credentials
3. **Redis Connection**: Verify Redis container is running
4. **Nginx 502**: Check if PHP-FPM is running properly
5. **Memory Issues**: Adjust PHP memory limits in php.ini

### Log Locations

- Application logs: `storage/logs/`
- Nginx logs: Container logs
- MySQL logs: `deploy/mysql/logs/`
- PHP-FPM logs: Container logs
- Supervisor logs: Container logs 