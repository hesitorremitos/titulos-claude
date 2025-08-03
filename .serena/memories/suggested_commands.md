# Suggested Commands for Development

## Primary Development Workflow
```bash
# Start development environment (runs server, queue, and vite concurrently)
composer run dev

# Alternative individual commands:
php artisan serve        # Start Laravel server
php artisan queue:listen --tries=1  # Start queue worker
npm run dev             # Start Vite development server
```

## Build and Asset Commands
```bash
npm run build           # Build production assets
npm install             # Install Node.js dependencies
composer install        # Install PHP dependencies
```

## Database Commands
```bash
php artisan migrate          # Run database migrations
php artisan migrate:fresh    # Drop all tables and re-run migrations
php artisan migrate:refresh  # Rollback and re-run migrations
php artisan db:seed          # Run database seeders
php artisan migrate:fresh --seed  # Fresh migration with seeders
```

## Testing Commands
```bash
composer run test       # Run full test suite (clears config first)
php artisan test        # Alternative test command
./vendor/bin/pest       # Direct Pest test runner
./vendor/bin/pest --filter=TestName  # Run specific test
```

## Code Quality Commands
```bash
./vendor/bin/pint       # PHP code style fixer (Laravel Pint)
```

## Windows System Commands
Since this is a Windows environment with Laragon:
```bash
# File operations
dir                     # List directory contents (equivalent to ls)
type filename.txt       # View file contents (equivalent to cat)
find "pattern" filename # Search in files (basic grep equivalent)
cd directory           # Change directory
mkdir directory        # Create directory
del filename           # Delete file
```

## Git Commands (Standard)
```bash
git status             # Check repository status
git add .              # Stage all changes
git commit -m "message" # Commit changes
git push               # Push to remote
git pull               # Pull from remote
```