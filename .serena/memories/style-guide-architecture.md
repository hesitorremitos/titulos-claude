# Style Guide Architecture 2025

## Updated Structure
The style guide has been restructured from a single file to a modular folder architecture:

### New Folder Structure
- `resources/views/style-guide/` - Main style guide directory
  - `index.blade.php` - Main style guide page
  - `partials/` - Shared layout components
    - `header.blade.php` - Style guide header
    - `navigation.blade.php` - Navigation menu
    - `footer.blade.php` - Footer component
    - `scripts.blade.php` - JavaScript includes
  - `sections/` - Individual component sections
    - `buttons.blade.php` - Button components showcase
    - `cards.blade.php` - Card components showcase
    - `colors.blade.php` - Color system
    - `complete-form.blade.php` - Complete form examples
    - `dashboard.blade.php` - Dashboard layouts
    - `feedback.blade.php` - Toast and validation messages
    - `forms.blade.php` - Form components showcase
    - `icons.blade.php` - Icon system
    - `navigation.blade.php` - Navigation components
    - `pdf-viewer.blade.php` - PDF viewer component
    - `searchable-select.blade.php` - Searchable select component
    - `toasts.blade.php` - Toast notifications
    - `typography.blade.php` - Typography system

### Controller
- `app/Http/Controllers/StyleGuideController.php` - Simple controller with index() method
- Route: `/style-guide` (public access, no auth required)

### Purpose
- Design system documentation and reference
- Component showcase for development consistency
- UI pattern library for the UATF titles system
- Visual testing of component variants and states

### Benefits of New Architecture
- Modular sections for easier maintenance
- Separated concerns (layout, navigation, content)
- Better organization for large component library
- Easier to add new sections and components
- Consistent layout structure across sections