# Contact Manager - Laravel

Sistema de gestión de contactos desarrollado con Laravel, Docker y Bootstrap.

## 🚀 Características

- CRUD completo de contactos
- Categorización de contactos (Personal, Familia, Trabajo, Amigos, Otro)
- Interfaz responsive con Bootstrap 5
- Dockerizado para fácil despliegue
- Validación de formularios
- Mensajes flash de confirmación

## 🛠️ Stack Tecnológico

- **Backend:** Laravel 10 + PHP 8.2
- **Frontend:** Bootstrap 5 + Blade Templates
- **Base de datos:** MySQL 8
- **Contenedores:** Docker + Docker Compose
- **Servidor:** Nginx

## 📦 Instalación

1. Clonar el repositorio:
```bash
git clone https://github.com/bbvedf/contact-manager-laravel.git
cd contact-manager-laravel`
```

2. Iniciar contenedores Docker:
docker-compose up -d --build

3. Acceder a la aplicación:
http://localhost:8085


## 🐛 Desarrollo
Ejecutar comandos Artisan:

```bash
docker-compose exec app php artisan [command]
```

Acceder a la base de datos:
```bash
docker-compose exec db mysql -u laraveluser -p contact_manager
```

## 📁 Estructura del Proyecto
contact-manager-laravel/ 
├── docker-compose.yml 
├── nginx/ 
├── mysql/ 
├── php/ 
├── src/                 # Código Laravel 
└── README.md 

## 📝 Licencia
MIT
