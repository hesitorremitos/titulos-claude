# Pattern: Action Buttons with shadcn/vue and Inertia.js

When creating buttons that perform actions other than a simple navigation (e.g., `DELETE`, `POST`, `PUT`), the `Button` component from `shadcn/vue` should be combined with the `Link` component from Inertia.js.

## The Problem

A common mistake is to try to add Inertia's `method` prop directly to the `Button` component, or to duplicate attributes like `as`. This will result in errors.

For example, the following code is incorrect and will cause a "Duplicate attribute" error:
```vue
<Button as="a" method="delete" as="button">...</Button>
```

## The Solution

The correct pattern is to use the `as-child` prop on the `Button` component. This allows the `Button` to pass its props and styling to its direct child component. The child component should be an Inertia `Link` component configured with the desired `href` and `method`.

### Example: Delete Button

```vue
<script setup>
import { Button } from '@/components/ui/button'
import { Link } from '@inertiajs/vue3'
import { Trash2 } from 'lucide-vue-next'
</script>

<template>
  <Button variant="ghost" size="icon" as-child>
    <Link :href="route('resource.destroy', id)" method="delete" as="button">
      <Trash2 class="h-4 w-4" />
    </Link>
  </Button>
</template>
```

This pattern ensures that:
- The button has the correct styling from `shadcn/vue`.
- The button has the correct behavior from Inertia.js (making a `DELETE` request in this case).
- The code is clean and easy to understand.
