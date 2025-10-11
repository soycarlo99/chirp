# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a Laravel 12 application implementing a "Chirper" social media platform (similar to Twitter) where users can post, edit, and delete short messages called "chirps". The application uses Laravel Reverb for real-time WebSocket broadcasting with Laravel Echo on the frontend.

## Common Commands

### Development
```bash
# Start full development environment (server, queue, logs, vite)
composer dev

# Or start components individually:
php artisan serve              # Development server (port 8000)
php artisan queue:listen --tries=1
php artisan pail --timeout=0   # Real-time log viewer
npm run dev                    # Vite dev server for assets

# Start Reverb WebSocket server
php artisan reverb:start
```

### Testing
```bash
# Run all tests
composer test
# Or: php artisan test

# Run specific test suite
php artisan test --testsuite=Feature
php artisan test --testsuite=Unit

# Run single test file
php artisan test tests/Feature/ExampleTest.php

# Run single test method
php artisan test --filter test_method_name
```

### Database
```bash
# Run migrations
php artisan migrate

# Fresh migration (reset and re-run)
php artisan migrate:fresh

# Rollback last migration
php artisan migrate:rollback

# Generate IDE helper files (uses barryvdh/laravel-ide-helper)
php artisan ide-helper:generate
php artisan ide-helper:models
```

### Code Quality
```bash
# Format code with Laravel Pint
./vendor/bin/pint

# Format specific files
./vendor/bin/pint app/Http/Controllers
```

### Assets
```bash
# Build for production
npm run build

# Development watch mode
npm run dev
```

## Architecture

### Authentication System
- Custom authentication controllers in `app/Http/Controllers/Auth/` (Register, Login, Logout)
- Uses Laravel's built-in session-based authentication
- Email verification implemented but currently commented out in routes
- Auth routes wrapped in `guest` middleware for login/register, `auth` middleware for protected routes

### Models & Relationships
- **User** (`app/Models/User.php`): Implements `MustVerifyEmail`, has many Chirps
- **Chirp** (`app/Models/Chirp.php`): Belongs to User, contains `message` field (max 255 chars)
- Both models use IDE helper annotations for better autocomplete

### Authorization
- ChirpPolicy (`app/Policies/ChirpPolicy.php`) controls who can update/delete chirps
- Only chirp owners can edit or delete their own chirps via `$chirp->user()->is($user)` check
- Authorization uses `$this->authorize()` in controller methods

### Real-time Broadcasting
- Laravel Reverb configured for WebSocket connections
- `ChirpSent` event (`app/Events/ChirpSent.php`) broadcasts to `public-chirps` channel
- Event broadcasts as `chirp.sent`
- Frontend uses Laravel Echo with Pusher.js for listening
- Note: Broadcasting is currently commented out in `ChirpController::store()` at line 41

### Routes Structure
- Main routes in `routes/web.php`
- Guest routes: `/register`, `/login` (GET + POST)
- Authenticated routes: home (`/`), chirp CRUD operations
- Test routes: `/send-chirp` and `/receive-data` for WebSocket testing
- Email verification routes present but verification middleware commented out

### Frontend
- Tailwind CSS 4.0 with Vite
- Blade templates in `resources/views/`
- Laravel Echo configured for real-time updates
- Primary views: `home.blade.php` (chirp feed), `receive.blade.php` (WebSocket test page)

### Key Implementation Details
- Chirps limited to 50 most recent on home page (`ChirpController::index()`)
- User relationships eager-loaded with `with('user')` to avoid N+1 queries
- Flash messages used for user feedback (`with('success', ...)`)
- SQLite configured for testing environment (see `phpunit.xml`)

## Development Notes

### Migration History Issue
Based on git history, this project was migrated from Laravel 10 to Laravel 11/12, which caused some authentication conflicts that have been resolved. The current implementation uses Laravel 12's structure.

### WebSocket Testing
- Use `/send-chirp` route to test broadcasting
- Use `/receive-data` view to test receiving broadcasted events
- Ensure Reverb server is running with `php artisan reverb:start`

### Database
- Uses SQLite in testing environment (`:memory:`)
- Check `.env` for production database configuration

### Queue System
- Queue configured and used in dev environment via `composer dev`
- Uses database driver by default (configure in `.env`)
