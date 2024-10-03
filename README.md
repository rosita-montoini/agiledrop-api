# Image API

## Setup

1. Configurated my MySQL database details in the `.env` file.
2. Created migration to add `images` table.
3. Run `php artisan migrate` to set up the database tables.
4. Installed Laravel Sanctum by running `composer require laravel/sanctum` for authentication with API tokens and migrated with `php artisan migrate`.
5. Started the server using `php artisan serve`.

Used Postman for checking all requests.

### Authentication

#### Login

1. Created seeder to add DefaultUser in the table `users`.

**Endpoint**: `/api/login`  
**Method**: `POST`  
**Request Body**:

-   `email`: (string, required, exists:users) Should be the same as in the db.
-   `password`: (string, required, min:8) The user's password.

**Response**:
Returns a JSON object with the API token.
The login is handled by the `LoginJob` which performs user authentication and generates an API token.

#### Logout

**Endpoint**: `/api/logout`  
**Method**: `POST`  
**Headers**:  
`Authorization: Bearer {API_TOKEN}`

The logout is handled by the `LogoutJob` which revokes the user's current API token.

#### Uploading image

**Endpoint**: `/api/upload-image`  
**Method**: `POST`  
**Request Body**:

-   `image`: (file) Upload file.
-   `title`: (string) Your image title.
-   `description`: (string) The image's description.

Returns a JSON object with the image information (size, type, path, ...).
Stored image to the /storage/app/public/images and added to the db.
