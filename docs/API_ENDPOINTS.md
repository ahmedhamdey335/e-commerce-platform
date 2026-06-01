# API Endpoints

This document describes the REST API endpoints supported by the e-commerce platform.
All API routes are prefixed with `/api`.

## Base URL

`http://localhost:8000/api`

## Authentication

### Login

`POST /api/login`

Request body:
```json
{
  "email": "user@example.com",
  "password": "password"
}
```

Success response:
```json
{
  "success": true,
  "message": "Login successful",
  "data": {
    "user": { ... },
    "token": "..."
  }
}
```

### Register

`POST /api/register`

Request body:
```json
{
  "name": "Jane Doe",
  "email": "jane@example.com",
  "password": "password",
  "password_confirmation": "password",
  "phone": "1234567890"
}
```

Success response: new user created and token returned.

### Logout

`POST /api/logout`

Headers:
- `Authorization: Bearer <token>`

Success response: token revoked.

### Current User

`GET /api/user`

Returns authenticated user details.

## Public Endpoints

### Products

`GET /api/products`
- Returns a paginated product list.
- Supports query parameters such as `page`, `per_page`, `search`, and filters.

`GET /api/products/{product}`
- Returns product detail by ID.

### Categories

`GET /api/categories`
- Returns a category list.

`GET /api/categories/{category}`
- Returns category detail by ID.

### Search

`GET /api/search`
- Search products by query parameters.

## Protected Endpoints

Protected routes require `Authorization: Bearer <token>`.

### Cart (customer only)

`GET /api/cart`
- Get current customer cart contents.

`POST /api/cart`
- Add an item to cart.
- Required body fields may include `product_id` and `quantity`.

`DELETE /api/cart/{cartItem}`
- Remove a cart item.

### Checkout & Orders

`POST /api/checkout`
- Create a new order from the customer cart.
- Requires valid shipping address data.

`GET /api/orders`
- List orders for the current user.
- Role-specific behavior:
  - `customer`: own orders
  - `seller`: orders containing their products
  - `admin`: all orders

`GET /api/orders/{order}`
- View a single order detail.

`PATCH /api/orders/{order}/status`
- Update order status (admin only).

### Addresses (customer only)

`GET /api/addresses`
- List customer addresses.

`POST /api/addresses`
- Create a new address.

`PUT /api/addresses/{address}`
- Update an address.

`DELETE /api/addresses/{address}`
- Delete an address.

### Product Management

`POST /api/products`
- Create a product (seller/admin).

`PUT /api/products/{product}`
`PATCH /api/products/{product}`
- Update a product.

`DELETE /api/products/{product}`
- Delete a product.

### Category Management

`POST /api/categories`
- Create a category (admin only).

`PUT /api/categories/{category}`
`PATCH /api/categories/{category}`
- Update a category.

`DELETE /api/categories/{category}`
- Delete a category.

## Response Format

### Success

```json
{
  "success": true,
  "message": "...",
  "data": { ... }
}
```

### Error

```json
{
  "success": false,
  "message": "...",
  "errors": { ... }
}
```

## Status Codes

- `200` OK
- `201` Created
- `400` Bad Request
- `401` Unauthorized
- `403` Forbidden
- `404` Not Found
- `422` Validation Failed
- `500` Server Error

## Roles

- `customer`: cart, checkout, orders, addresses
- `seller`: manage own products, view related orders
- `admin`: full product/category/order control

## Notes

- Protected endpoints use `auth:sanctum`.
- Role enforcement is handled by middleware and policies.
- The API returns JSON consistently for both success and error cases.
