# Task Completion Checklist

## Mandatory Steps After Code Changes

### 1. Code Quality
```bash
./vendor/bin/pint       # Run PHP code style fixer
```

### 2. Testing
```bash
composer run test       # Run full test suite
# OR
php artisan test        # Alternative test command
```

### 3. Database Integrity (if migrations involved)
```bash
php artisan migrate:fresh --seed  # Fresh migration with seeders
```

### 4. Build Assets (if frontend changes)
```bash
npm run build           # Build production assets
```

## Verification Steps

### 1. Functionality Testing
- Test the specific feature implemented
- Verify permissions work correctly for different user roles
- Check that audit trails are recorded properly

### 2. Integration Testing
- Ensure external API integrations still work (University API)
- Verify file upload/download functionality if affected
- Test navigation and UI components

### 3. Database Consistency
- Verify foreign key relationships are maintained
- Check that required fields have proper validation
- Ensure CI (Carnet de Identidad) uniqueness is preserved

### 4. Performance Considerations
- Verify eager loading is used to prevent N+1 queries
- Check that large datasets are paginated
- Ensure file storage paths are correct

## Pre-Commit Requirements

### NEVER commit if:
- Tests are failing
- Code style (Pint) shows violations
- Database migrations fail
- Build process encounters errors
- Feature doesn't work for all intended user roles

### ALWAYS verify:
- All new files are properly tracked in git
- Sensitive information (API keys, passwords) are not included
- File permissions follow project patterns
- New routes are properly protected with middleware

## Documentation Updates (if applicable)
- Update CLAUDE.md file index if new files were created
- Verify specs/ documentation reflects changes made
- Ensure memory files are updated with new patterns or conventions