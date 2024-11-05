# Project structure and file organization
[[Back to index]](./coding-guidelines.md)

- [Backend structure](project-structure.md)
- [Frontend structure](project-structure.md)

## Backend structure

...

## Frontend structure

### Components
All React components should be created within the `.src/components` folder. These components should focus solely on rendering and presenting data. They should not contain any logic or API calls.

### Pages
Create new pages within the `.src/pages folder`. Pages should serve as the top-level components that define the structure of a route and may contain a composition of components. Keep pages clean and avoid adding complex logic directly to them.
