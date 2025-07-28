# Social Media API Documentation

## Overview

This is a comprehensive social media API built with Laravel that provides endpoints for user authentication, posts, comments, user interactions, and more. The API is fully documented using OpenAPI 3.0 specifications.

## API Base URL

```
http://localhost:8000/api
```

## Authentication

The API uses Laravel Sanctum for authentication. Most endpoints require a Bearer token in the Authorization header:

```
Authorization: Bearer {your_token}
```

## Getting Started

### 1. Installation

```bash
# Clone the repository
git clone <repository-url>

# Install dependencies
composer install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Run migrations
php artisan migrate

# Seed the database (optional)
php artisan db:seed

# Start the development server
php artisan serve
```

### 2. Generate API Documentation

The API documentation is generated using L5-Swagger. To generate the documentation:

```bash
# Generate the OpenAPI specification
php artisan l5-swagger:generate
```

The documentation will be available at:
```
http://localhost:8000/api/documentation
```

## API Endpoints Overview

### Authentication Endpoints

| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| POST | `/auth/register` | Register a new user | No |
| POST | `/auth/login` | Login user | No |
| POST | `/auth/logout` | Logout user | Yes |

### User Management

| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| GET | `/users/{user}` | Get user profile | No |
| PUT | `/users/{user}` | Update user profile | Yes |
| GET | `/users/{user}/posts` | Get user posts | No |
| GET | `/users/generate-bio` | Generate bio with AI | Yes |

### User Interactions

| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| GET | `/users/{user}/followers` | Get user followers | No |
| GET | `/users/{user}/following` | Get user following | No |
| POST | `/users/{user}/follow` | Follow a user | Yes |
| DELETE | `/users/{user}/unfollow` | Unfollow a user | Yes |
| POST | `/users/{user}/block` | Block a user | Yes |
| DELETE | `/users/{user}/unblock` | Unblock a user | Yes |

### Posts

| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| GET | `/posts` | Get main feed | No |
| POST | `/posts` | Create a new post | Yes |
| GET | `/posts/{post}` | Get specific post | No |
| PUT | `/posts/{post}` | Update a post | Yes |
| DELETE | `/posts/{post}` | Delete a post | Yes |

### Post Interactions

| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| POST | `/posts/{post}/like` | Like a post | Yes |
| DELETE | `/posts/{post}/unlike` | Unlike a post | Yes |
| POST | `/posts/{post}/pin` | Pin a post | Yes |
| POST | `/posts/{post}/unpin` | Unpin a post | Yes |

### Comments

| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| GET | `/posts/{post}/comments` | Get post comments | No |
| POST | `/posts/{post}/comments` | Add comment to post | Yes |
| GET | `/comments/{comment}` | Get specific comment | No |
| PUT | `/comments/{comment}` | Update a comment | Yes |
| DELETE | `/comments/{comment}` | Delete a comment | Yes |

### Comment Interactions

| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| POST | `/comments/{comment}/like` | Like a comment | Yes |
| DELETE | `/comments/{comment}/unlike` | Unlike a comment | Yes |
| GET | `/comments/{comment}/replies` | Get comment replies | No |
| POST | `/comments/{comment}/reply` | Reply to a comment | Yes |

### Tags

| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| GET | `/tags` | Get all tags | No |
| GET | `/tags/{tag}/posts` | Get posts by tag | No |
| GET | `/tags/{tag}/comments` | Get comments by tag | No |

### Search & Feed

| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| GET | `/search` | Search content | No |
| GET | `/posts` | Get main feed | No |

## Request/Response Format

### Standard Response Format

All API responses follow a consistent format:

```json
{
  "success": true,
  "status": 200,
  "message": "Operation completed successfully",
  "data": {
    // Response data here
  }
}
```

### Error Response Format

```json
{
  "success": false,
  "status": 400,
  "message": "Validation failed",
  "errors": {
    "field": ["Error message"]
  }
}
```

## Data Models

### User Model

```json
{
  "id": 1,
  "username": "john_doe",
  "email": "john@example.com",
  "avatar": "https://example.com/avatar.jpg",
  "bio": "Software developer",
  "website": "https://example.com",
  "location": "New York",
  "birthdate": "1990-01-01",
  "gender": "male",
  "is_private": false,
  "verified": false,
  "status": "active",
  "created_at": "2024-01-01T00:00:00.000000Z",
  "updated_at": "2024-01-01T00:00:00.000000Z"
}
```

### Post Model

```json
{
  "id": 1,
  "user": {
    // User object
  },
  "title": "My First Post",
  "content": "This is the content of my post",
  "type": "text",
  "status": "public",
  "is_pinned": false,
  "is_deleted": false,
  "shares": 0,
  "likes_count": 5,
  "comments_count": 3,
  "is_liked": true,
  "media": [
    // Media objects
  ],
  "created_at": "2024-01-01T00:00:00.000000Z",
  "updated_at": "2024-01-01T00:00:00.000000Z"
}
```

### Comment Model

```json
{
  "id": 1,
  "user": {
    // User object
  },
  "content": "Great post!",
  "parent_id": null,
  "likes_count": 2,
  "is_liked": false,
  "created_at": "2024-01-01T00:00:00.000000Z",
  "updated_at": "2024-01-01T00:00:00.000000Z"
}
```

## File Upload

The API supports file uploads for posts and comments. Supported file types:

- **Images**: JPEG, JPG, PNG, GIF
- **Videos**: MP4
- **Audio**: MP3
- **Documents**: PDF, DOCX

Maximum file size: 10MB per file

### Upload Example

```bash
curl -X POST "http://localhost:8000/api/posts" \
  -H "Authorization: Bearer {your_token}" \
  -H "Content-Type: multipart/form-data" \
  -F "title=My Post" \
  -F "content=Post content" \
  -F "media[]=@image1.jpg" \
  -F "media[]=@image2.jpg"
```

## Pagination

Most list endpoints support pagination. The response includes pagination metadata:

```json
{
  "current_page": 1,
  "data": [...],
  "first_page_url": "http://localhost:8000/api/posts?page=1",
  "from": 1,
  "last_page": 5,
  "last_page_url": "http://localhost:8000/api/posts?page=5",
  "next_page_url": "http://localhost:8000/api/posts?page=2",
  "path": "http://localhost:8000/api/posts",
  "per_page": 10,
  "prev_page_url": null,
  "to": 10,
  "total": 50
}
```

## Error Codes

| Code | Description |
|------|-------------|
| 200 | Success |
| 201 | Created |
| 400 | Bad Request |
| 401 | Unauthorized |
| 403 | Forbidden |
| 404 | Not Found |
| 422 | Validation Error |
| 500 | Internal Server Error |

## Rate Limiting

The API implements rate limiting to prevent abuse. Limits are applied per IP address and user account.

## Testing

The API includes comprehensive test suites. To run tests:

```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test --filter PostTest

# Run tests with coverage
php artisan test --coverage
```

## Development

### Adding New Endpoints

1. Create the controller method
2. Add the route to `routes/api.php`
3. Add OpenAPI annotations to the controller
4. Create/update request validation classes
5. Create/update resource classes for responses
6. Add tests

### Code Style

The project follows PSR-12 coding standards. To check code style:

```bash
# Install PHP CS Fixer
composer require --dev friendsofphp/php-cs-fixer

# Check code style
./vendor/bin/php-cs-fixer fix --dry-run

# Fix code style
./vendor/bin/php-cs-fixer fix
```

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests for new functionality
5. Update documentation
6. Submit a pull request

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Support

For support and questions:

- Create an issue on GitHub
- Email: support@socialmedia.com
- Documentation: http://localhost:8000/api/documentation 