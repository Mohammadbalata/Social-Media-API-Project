<?php

/**
 * @OA\Info(
 *     title="Social Media API",
 *     version="1.0.0",
 *     description="A comprehensive social media API with authentication, posts, comments, users, and interactions",
 *     @OA\Contact(
 *         email="support@socialmedia.com",
 *         name="API Support"
 *     ),
 *     @OA\License(
 *         name="MIT",
 *         url="https://opensource.org/licenses/MIT"
 *     )
 * )
 * 
 * @OA\Server(
 *     url="http://localhost:8000/api",
 *     description="Local Development Server"
 * )
 * 
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 * 
 * @OA\Tag(
 *     name="Authentication",
 *     description="User authentication endpoints"
 * )
 * 
 * @OA\Tag(
 *     name="Users",
 *     description="User management and profile operations"
 * )
 * 
 * @OA\Tag(
 *     name="Posts",
 *     description="Post creation, management, and interactions"
 * )
 * 
 * @OA\Tag(
 *     name="Comments",
 *     description="Comment management and interactions"
 * )
 * 
 * @OA\Tag(
 *     name="Tags",
 *     description="Tag-related operations"
 * )
 * 
 * @OA\Tag(
 *     name="Feed",
 *     description="Homepage feed and search operations"
 * )
 */

namespace App\Http\Controllers\Api;

/**
 * @OA\Schema(
 *     schema="User",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="username", type="string", example="john_doe"),
 *     @OA\Property(property="email", type="string", format="email", example="john@example.com"),
 *     @OA\Property(property="avatar", type="string", nullable=true, example="https://example.com/avatar.jpg"),
 *     @OA\Property(property="bio", type="string", nullable=true, example="Software developer"),
 *     @OA\Property(property="website", type="string", nullable=true, example="https://example.com"),
 *     @OA\Property(property="location", type="string", nullable=true, example="New York"),
 *     @OA\Property(property="birthdate", type="string", format="date", nullable=true, example="1990-01-01"),
 *     @OA\Property(property="gender", type="string", enum={"male", "female", "other"}, nullable=true),
 *     @OA\Property(property="is_private", type="boolean", example=false),
 *     @OA\Property(property="verified", type="boolean", example=false),
 *     @OA\Property(property="status", type="string", example="active"),
 *     @OA\Property(property="last_seen", type="string", format="date-time", nullable=true),
 *     @OA\Property(property="email_verified_at", type="string", format="date-time", nullable=true),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 * 
 * @OA\Schema(
 *     schema="Post",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="user", ref="#/components/schemas/User"),
 *     @OA\Property(property="title", type="string", example="My First Post"),
 *     @OA\Property(property="content", type="string", example="This is the content of my post"),
 *     @OA\Property(property="type", type="string", example="text"),
 *     @OA\Property(property="status", type="string", enum={"public", "archived", "private"}, example="public"),
 *     @OA\Property(property="is_pinned", type="boolean", example=false),
 *     @OA\Property(property="is_deleted", type="boolean", example=false),
 *     @OA\Property(property="shares", type="integer", example=0),
 *     @OA\Property(property="likes_count", type="integer", example=5),
 *     @OA\Property(property="comments_count", type="integer", example=3),
 *     @OA\Property(property="is_liked", type="boolean", example=true),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 * 
 * @OA\Schema(
 *     schema="Comment",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="user", ref="#/components/schemas/User"),
 *     @OA\Property(property="content", type="string", example="Great post!"),
 *     @OA\Property(property="parent_id", type="integer", nullable=true, example=null),
 *     @OA\Property(property="likes_count", type="integer", example=2),
 *     @OA\Property(property="is_liked", type="boolean", example=false),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 * 
 * @OA\Schema(
 *     schema="Tag",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="technology"),
 *     @OA\Property(property="posts_count", type="integer", example=10),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 * 
 * @OA\Schema(
 *     schema="Media",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="url", type="string", example="https://example.com/media/file.jpg"),
 *     @OA\Property(property="type", type="string", enum={"image", "video", "audio", "document"}, example="image"),
 *     @OA\Property(property="filename", type="string", example="file.jpg"),
 *     @OA\Property(property="size", type="integer", example=1024000),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 * 
 * @OA\Schema(
 *     schema="Pagination",
 *     @OA\Property(property="current_page", type="integer", example=1),
 *     @OA\Property(property="data", type="array", @OA\Items(type="object")),
 *     @OA\Property(property="first_page_url", type="string"),
 *     @OA\Property(property="from", type="integer", example=1),
 *     @OA\Property(property="last_page", type="integer", example=5),
 *     @OA\Property(property="last_page_url", type="string"),
 *     @OA\Property(property="next_page_url", type="string", nullable=true),
 *     @OA\Property(property="path", type="string"),
 *     @OA\Property(property="per_page", type="integer", example=10),
 *     @OA\Property(property="prev_page_url", type="string", nullable=true),
 *     @OA\Property(property="to", type="integer", example=10),
 *     @OA\Property(property="total", type="integer", example=50)
 * )
 * 
 * @OA\Schema(
 *     schema="SuccessResponse",
 *     @OA\Property(property="success", type="boolean", example=true),
 *     @OA\Property(property="status", type="integer", example=200),
 *     @OA\Property(property="message", type="string", example="Operation completed successfully"),
 *     @OA\Property(property="data", type="object")
 * )
 * 
 * @OA\Schema(
 *     schema="ErrorResponse",
 *     @OA\Property(property="success", type="boolean", example=false),
 *     @OA\Property(property="status", type="integer", example=400),
 *     @OA\Property(property="message", type="string", example="Validation failed"),
 *     @OA\Property(property="errors", type="object", nullable=true)
 * )
 * 
 * @OA\Schema(
 *     schema="LoginRequest",
 *     required={"email", "password", "fcm_token"},
 *     @OA\Property(property="email", type="string", format="email", example="user@example.com"),
 *     @OA\Property(property="password", type="string", example="password123"),
 *     @OA\Property(property="fcm_token", type="string", example="fcm_token_here")
 * )
 * 
 * @OA\Schema(
 *     schema="RegisterRequest",
 *     required={"username", "email", "password", "password_confirmation"},
 *     @OA\Property(property="username", type="string", maxLength=255, example="john_doe"),
 *     @OA\Property(property="email", type="string", format="email", maxLength=255, example="john@example.com"),
 *     @OA\Property(property="password", type="string", minLength=8, example="password123"),
 *     @OA\Property(property="password_confirmation", type="string", example="password123")
 * )
 * 
 * @OA\Schema(
 *     schema="PostRequest",
 *     required={"title", "content"},
 *     @OA\Property(property="title", type="string", maxLength=255, example="My Post Title"),
 *     @OA\Property(property="content", type="string", example="This is the content of my post"),
 *     @OA\Property(property="media", type="array", @OA\Items(type="file"), maxItems=5),
 *     @OA\Property(property="status", type="string", enum={"public", "archived", "private"}, example="public")
 * )
 * 
 * @OA\Schema(
 *     schema="CommentRequest",
 *     required={"content"},
 *     @OA\Property(property="content", type="string", maxLength=1000, example="This is a comment"),
 *     @OA\Property(property="parent_id", type="integer", nullable=true, example=null),
 *     @OA\Property(property="media", type="array", @OA\Items(type="file"), maxItems=1)
 * )
 * 
 * @OA\Schema(
 *     schema="UpdateUserRequest",
 *     @OA\Property(property="username", type="string", maxLength=255, example="new_username"),
 *     @OA\Property(property="email", type="string", format="email", maxLength=255, example="newemail@example.com"),
 *     @OA\Property(property="bio", type="string", maxLength=500, example="Updated bio"),
 *     @OA\Property(property="avatar", type="file", format="binary"),
 *     @OA\Property(property="website", type="string", format="url", maxLength=255, example="https://example.com"),
 *     @OA\Property(property="location", type="string", maxLength=255, example="New York"),
 *     @OA\Property(property="birthdate", type="string", format="date", example="1990-01-01"),
 *     @OA\Property(property="gender", type="string", enum={"male", "female", "other"}, example="male"),
 *     @OA\Property(property="is_private", type="boolean", example=false)
 * )
 * 
 * @OA\Schema(
 *     schema="LoginResponse",
 *     @OA\Property(property="token", type="string", example="1|abc123def456..."),
 *     @OA\Property(property="user", ref="#/components/schemas/User")
 * )
 * 
 * @OA\Schema(
 *     schema="RegisterResponse",
 *     @OA\Property(property="user", ref="#/components/schemas/User"),
 *     @OA\Property(property="token", type="string", example="1|abc123def456...")
 * )
 */

class OpenApiDocumentation
{
    // This class serves as a container for OpenAPI documentation
    // All annotations are defined above
} 