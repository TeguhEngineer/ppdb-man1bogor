# API Documentation - Laravel 11 Basecode

## Base URL
```
http://localhost:8000/api/v1
```

## Authentication

All protected endpoints require Bearer token authentication:
```
Authorization: Bearer {your-token}
```

---

## Public Endpoints

### 1. Login
**Endpoint:** `POST /api/v1/login`

**Request Body:**
```json
{
  "email": "administrator@gmail.com",
  "password": "password"
}
```

**Success Response (200):**
```json
{
  "success": true,
  "message": "Login successful",
  "data": {
    "user": {
      "id": 1,
      "name": "Administrator",
      "email": "administrator@gmail.com",
      "telepon": "08123456789",
      "role": "administrator",
      "email_verified_at": null,
      "created_at": "2026-02-06T15:00:00.000000Z",
      "updated_at": "2026-02-06T15:00:00.000000Z"
    },
    "token": "1|abcdefghijklmnopqrstuvwxyz..."
  }
}
```

**Error Response (401):**
```json
{
  "success": false,
  "message": "Login failed",
  "error": "The provided credentials are incorrect."
}
```

---

### 2. Register
**Endpoint:** `POST /api/v1/register`

**Request Body:**
```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123",
  "password_confirmation": "password123",
  "telepon": "08123456789"
}
```

**Validation Rules:**
- `name`: required, string, max 100 characters
- `email`: required, email, unique
- `password`: required, min 8 characters, confirmed
- `telepon`: optional, numeric, 11-13 digits
- `role`: automatically set to "operator"

**Success Response (201):**
```json
{
  "success": true,
  "message": "Registration successful",
  "data": {
    "user": {...},
    "token": "2|abcdefghijklmnopqrstuvwxyz..."
  }
}
```

---

## Protected Endpoints

### Authentication Required

#### 3. Get Current User
**Endpoint:** `GET /api/v1/user`

**Headers:**
```
Authorization: Bearer {token}
```

**Success Response (200):**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "name": "Administrator",
    "email": "administrator@gmail.com",
    "telepon": "08123456789",
    "role": "administrator",
    "email_verified_at": null,
    "created_at": "2026-02-06T15:00:00.000000Z",
    "updated_at": "2026-02-06T15:00:00.000000Z"
  }
}
```

---

#### 4. Logout
**Endpoint:** `POST /api/v1/logout`

**Headers:**
```
Authorization: Bearer {token}
```

**Success Response (200):**
```json
{
  "success": true,
  "message": "Logout successful"
}
```

---

## User Management (Admin Only)

### 5. Get All Users
**Endpoint:** `GET /api/v1/users`

**Headers:**
```
Authorization: Bearer {token}
```

**Query Parameters:**
- `per_page` (optional): Number of items per page (default: 10)
- `search` (optional): Search by name or email

**Example:**
```
GET /api/v1/users?per_page=25&search=admin
```

**Success Response (200):**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "name": "Administrator",
      "email": "administrator@gmail.com",
      "telepon": "08123456789",
      "role": "administrator",
      "email_verified_at": null,
      "created_at": "2026-02-06T15:00:00.000000Z",
      "updated_at": "2026-02-06T15:00:00.000000Z"
    }
  ],
  "meta": {
    "current_page": 1,
    "last_page": 1,
    "per_page": 10,
    "total": 2
  }
}
```

---

### 6. Create User
**Endpoint:** `POST /api/v1/users`

**Headers:**
```
Authorization: Bearer {token}
Content-Type: application/json
```

**Request Body:**
```json
{
  "name": "New User",
  "email": "newuser@example.com",
  "password": "password123",
  "telepon": "08123456789",
  "role": "operator"
}
```

**Success Response (201):**
```json
{
  "success": true,
  "message": "User created successfully",
  "data": {...}
}
```

---

### 7. Get Single User
**Endpoint:** `GET /api/v1/users/{id}`

**Headers:**
```
Authorization: Bearer {token}
```

**Success Response (200):**
```json
{
  "success": true,
  "data": {...}
}
```

**Error Response (404):**
```json
{
  "success": false,
  "message": "User not found"
}
```

---

### 8. Update User
**Endpoint:** `PUT /api/v1/users/{id}`

**Headers:**
```
Authorization: Bearer {token}
Content-Type: application/json
```

**Request Body:**
```json
{
  "name": "Updated Name",
  "email": "updated@example.com",
  "telepon": "08987654321",
  "role": "administrator"
}
```

**Success Response (200):**
```json
{
  "success": true,
  "message": "User updated successfully",
  "data": {...}
}
```

---

### 9. Delete User
**Endpoint:** `DELETE /api/v1/users/{id}`

**Headers:**
```
Authorization: Bearer {token}
```

**Success Response (200):**
```json
{
  "success": true,
  "message": "User deleted successfully"
}
```

---

## Product Management (Admin & Operator)

### 10. Get All Products
**Endpoint:** `GET /api/v1/produk`

**Headers:**
```
Authorization: Bearer {token}
```

**Query Parameters:**
- `per_page` (optional): Number of items per page (default: 10)
- `search` (optional): Search by product name

**Success Response (200):**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "name": "Product Name",
      "description": "Product description",
      "price": "100000.00",
      "stock": 50,
      "image": "http://localhost:8000/storage/products/image.jpg",
      "created_at": "2026-02-06T15:00:00.000000Z",
      "updated_at": "2026-02-06T15:00:00.000000Z"
    }
  ],
  "meta": {
    "current_page": 1,
    "last_page": 1,
    "per_page": 10,
    "total": 1
  }
}
```

---

### 11. Create Product
**Endpoint:** `POST /api/v1/produk`

**Headers:**
```
Authorization: Bearer {token}
Content-Type: multipart/form-data
```

**Request Body (Form Data):**
```
name: Product Name
description: Product description
price: 100000
stock: 50
image: [file]
```

**Validation Rules:**
- `name`: required, string, max 255 characters
- `description`: optional, string
- `price`: required, numeric, min 0
- `stock`: required, integer, min 0
- `image`: optional, image (jpeg, png, jpg, gif), max 2MB

**Success Response (201):**
```json
{
  "success": true,
  "message": "Product created successfully",
  "data": {...}
}
```

---

### 12. Get Single Product
**Endpoint:** `GET /api/v1/produk/{id}`

**Headers:**
```
Authorization: Bearer {token}
```

**Success Response (200):**
```json
{
  "success": true,
  "data": {...}
}
```

---

### 13. Update Product
**Endpoint:** `PUT /api/v1/produk/{id}` or `POST /api/v1/produk/{id}` (with `_method=PUT`)

**Headers:**
```
Authorization: Bearer {token}
Content-Type: multipart/form-data
```

**Request Body (Form Data):**
```
name: Updated Product Name
description: Updated description
price: 150000
stock: 75
image: [file] (optional)
_method: PUT (if using POST)
```

**Success Response (200):**
```json
{
  "success": true,
  "message": "Product updated successfully",
  "data": {...}
}
```

---

### 14. Delete Product
**Endpoint:** `DELETE /api/v1/produk/{id}`

**Headers:**
```
Authorization: Bearer {token}
```

**Success Response (200):**
```json
{
  "success": true,
  "message": "Product deleted successfully"
}
```

---

## Error Responses

### 401 Unauthorized
```json
{
  "message": "Unauthenticated."
}
```

### 403 Forbidden
```json
{
  "message": "Unauthorized. Hanya administrator yang dapat mengakses halaman ini."
}
```

### 422 Validation Error
```json
{
  "success": false,
  "message": "Failed to create user",
  "error": "The email has already been taken."
}
```

### 500 Internal Server Error
```json
{
  "success": false,
  "message": "Failed to fetch users",
  "error": "Error message details"
}
```

---

## Testing with cURL

### Login Example
```bash
curl -X POST http://localhost:8000/api/v1/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "administrator@gmail.com",
    "password": "password"
  }'
```

### Get Users Example
```bash
curl -X GET http://localhost:8000/api/v1/users \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

### Create Product with Image
```bash
curl -X POST http://localhost:8000/api/v1/produk \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -F "name=New Product" \
  -F "description=Product description" \
  -F "price=100000" \
  -F "stock=50" \
  -F "image=@/path/to/image.jpg"
```

---

## Rate Limiting

API endpoints are rate limited to prevent abuse. Default limits apply per minute per IP address.

## Notes

1. All timestamps are in UTC
2. Image URLs are absolute paths including domain
3. Prices are stored as decimal with 2 decimal places
4. Stock values must be non-negative integers
5. Role values are case-sensitive: "administrator" or "operator"
