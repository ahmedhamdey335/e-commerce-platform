# Architecture

This project is a Laravel 12 e-commerce platform with a REST API backend and role-based access control.

## Overview

The application follows Laravel's MVC architecture. API routes are defined in `routes/api.php` and web views are defined in `routes/web.php`.

## Key Layers

- **Routes**: `routes/api.php` for API endpoints, `routes/web.php` for Blade views.
- **Controllers**: `app/Http/Controllers/Api` for API logic, `app/Http/Controllers/Web` for UI controllers.
- **Middleware**: `app/Http/Middleware/CheckRole.php` enforces role-based access.
- **Models**: `app/Models` contains domain models such as `User`, `Product`, `Order`, `Category`, `CartItem`, and `Address`.
- **Policies**: `app/Policies` contains authorization rules for resources.
- **Resources**: `app/Http/Resources` formats API responses.

## Request Flow

1. Request enters Laravel and matches a route.
2. Middleware checks authentication and role permissions.
3. Controller validates the request and applies business logic.
4. Model objects interact with the database.
5. Response is returned as JSON or a Blade view.

## Roles and Permissions

- `customer`
  - Browse products and categories
  - Manage cart
  - Checkout and place orders
  - Manage shipping addresses
  - View own orders

- `seller`
  - Create and manage own products
  - View orders containing their products

- `admin`
  - Manage all products
  - Manage categories
  - Update order statuses
  - View all orders

## Authorization

Authorization is enforced with both middleware and policies.

- `CheckRole` middleware verifies the authenticated user role.
- Policies govern resource-level access, such as `ProductPolicy` and `OrderPolicy`.

## API Response Pattern

The API uses a consistent JSON structure with `success`, `message`, and `data` keys.

Example:
```json
{
  "success": true,
  "message": "Request processed successfully",
  "data": { ... }
}
```

## Directory Summary

- `app/Http/Controllers/Api` — API endpoint controllers
- `app/Http/Middleware` — Request middleware
- `app/Models` — Database-backed models
- `app/Policies` — Authorization logic
- `app/Http/Resources` — JSON transformers
- `database/migrations` — Schema definitions
- `database/factories` — Test data factories
- `database/seeders` — Seed data setup
- `resources/views` — Blade templates and layouts
- `tests` — Feature and unit tests

## Documentation
Project documentation is stored in the `docs/` directory.
