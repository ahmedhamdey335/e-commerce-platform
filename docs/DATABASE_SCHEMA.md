# Database Schema

This document describes the main database tables used by the e-commerce platform.

## users

Columns:
- `id`
- `name`
- `email`
- `password`
- `phone`
- `role`
- `remember_token`
- `created_at`
- `updated_at`

Notes:
- `role` values are `customer`, `seller`, or `admin`.
- Users are authenticated with Laravel Sanctum tokens.

## products

Columns:
- `id`
- `user_id` (seller owner)
- `name`
- `slug`
- `description`
- `price`
- `stock`
- `image`
- `created_at`
- `updated_at`

Notes:
- `user_id` links to the seller who manages the product.
- `slug` is used for SEO-friendly identifiers.

## categories

Columns:
- `id`
- `name`
- `slug`
- `description`
- `created_at`
- `updated_at`

Notes:
- Categories are assigned to products through a pivot table.

## category_product

Columns:
- `category_id`
- `product_id`
- `created_at`

Notes:
- Pivot table for product-category relationships.

## cart_items

Columns:
- `id`
- `user_id`
- `product_id`
- `quantity`
- `created_at`
- `updated_at`

Notes:
- Each cart item belongs to a customer user and references a product.

## orders

Columns:
- `id`
- `user_id`
- `total_price`
- `status`
- `address`
- `created_at`
- `updated_at`

Notes:
- Orders belong to customers.
- `status` tracks order state.

## order_items

Columns:
- `id`
- `order_id`
- `product_id`
- `quantity`
- `price`
- `created_at`
- `updated_at`

Notes:
- Order items store product pricing at the time of purchase.

## addresses

Columns:
- `id`
- `user_id`
- `name`
- `street`
- `city`
- `state`
- `postal_code`
- `country`
- `phone`
- `is_default`
- `created_at`
- `updated_at`

Notes:
- Addresses belong to customers and are used during checkout.

## personal_access_tokens

Columns:
- `id`
- `tokenable_type`
- `tokenable_id`
- `name`
- `token`
- `abilities`
- `last_used_at`
- `expires_at`
- `created_at`
- `updated_at`

Notes:
- Laravel Sanctum table for API tokens.
- Used by the authenticated API endpoints.

## Relationships

- `users` → `products` (one-to-many)
- `users` → `orders` (one-to-many)
- `users` → `cart_items` (one-to-many)
- `users` → `addresses` (one-to-many)
- `products` → `categories` (many-to-many via `category_product`)
- `orders` → `order_items` (one-to-many)
- `cart_items` → `products` (many-to-one)
- `order_items` → `products` (many-to-one)

## Notes

- Migrations live under `database/migrations`.
- Factories are in `database/factories`.
- Seeders are in `database/seeders`.
- Order totals are calculated from `order_items`.
