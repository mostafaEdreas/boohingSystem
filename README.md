# Hotel Booking System

A Laravel application for managing hotels and rooms, with a web dashboard and a REST API. Users can search for available rooms by city, dates, and guest count. The API is protected by token authentication (Laravel Sanctum) and rate limiting.

## Features

- **Web dashboard** (authenticated)
  - Manage hotels (create, list, edit, delete)
  - Manage rooms (create, list) linked to hotels
  - Search availability by city, check-in/check-out dates, and number of guests
  - Dashboard overview (stats: hotels, rooms, ratings, cities, countries)

  
  ## 🛡️ Error Handling & Developer Mode

  This application features a custom exception handling layer designed to protect sensitive data while providing developers with a "hidden" debug mode.

  ### 1. Dedicated Error Logging
  All critical system errors (HTTP 500) are automatically intercepted and recorded in a custom log file for easier maintenance:
  * **Path:** `storage/logs/500.log`
  * **Captured Data:** Error message and timestamp (Web and API).

  ### 2. Smart Error Responses
  The system adapts its error messages based on the request type and environment settings:

  | Request Type | Mode | Result |
  | :--- | :--- | :--- |
  | **Web (Browser)** | Production | Redirects **back** with a Bootstrap alert: *"There is an unexpected error..."* |
  | **API (JSON)** | Production | Returns JSON: `{ "status": "error", "message": "..." }` |
  | **Any** | Developer Mode | Shows full Laravel stack trace/Ignition debug page. |

  ### 3. Developer Mode Configuration
  To see full error details (Developer Mode), ensure your `.env` meets **one** of these conditions:
  ```env
  # Option A: Global Debug
  APP_DEBUG=true

  # Option B: Selective Dev Mode (Environment must be production + APP_DEV true)
  APP_ENV=production
  APP_DEV=true

- **REST API**
  - **Auth:** Login (returns token), Logout (revokes token). Token required for all other endpoints.
  - **Hotels:** Create hotel, List hotels with filters (city, rating) and pagination
  - **Rooms:** Create room (linked to a hotel)
  - **Search:** Search availability by city, check-in date, check-out date, guests — returns hotels with available rooms and total price (price × nights)
  - **Rate limiting:** Login limited to 5 requests/minute per IP; API endpoints to 60 requests/minute per user/IP

## Tech Stack

- **PHP** 8.2+
- **Laravel** 12
- **Laravel Sanctum** (API token auth)
- **Laravel UI** (web auth scaffolding)
- **Tailwind CSS** 4, **Vite**
- **Pest** (testing)
- **MySQL** / **MariaDB** (or SQLite for local dev)

## Requirements

- PHP 8.2 or higher
- Composer
- Node.js & npm (for frontend assets)
- MySQL, MariaDB, or SQLite

## Installation

### 1. Clone the repository

```bash
git clone https://github.com/mostafaEdreas/boohingSystem.git 
cd bookingSystem
```

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Environment configuration

Copy the example environment file and generate the application key:

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` and set your database connection. For example, for MySQL:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=booking_system
DB_USERNAME=root
DB_PASSWORD=
```


### 4. Run migrations and seeder

```bash
php artisan migrate --seed
```

### 5. Install frontend dependencies and build assets

```bash
npm install
npm run build
```

For development with hot reload, use `npm run dev` in a separate terminal instead of `npm run build`.


(Ensure `.env` and database are configured before or after as needed.)

## Running the application

Start the Laravel development server:

```bash
php artisan serve
```

The app will be available at `http://localhost:8000`. Redirect to the dashboard and log in (or register) to use the web interface.



## API Overview

Base URL: `http://localhost:8000/api` (or your app URL + `/api`).

- All endpoints expect **Accept: application/json**.
- Protected endpoints require **Authorization: Bearer {token}** (token returned by Login).

| Method | Endpoint       | Auth   | Description                    |
|--------|----------------|--------|--------------------------------|
| POST   | `/api/login`   | No     | Login; returns user and token  |
| POST   | `/api/logout`  | Token  | Logout; revokes current token  |
| GET    | `/api/hotels`  | Token  | List hotels (query: city, rating, per_page) |
| POST   | `/api/hotels`  | Token  | Create hotel (name, city, country, rating)  |
| POST   | `/api/rooms`   | Token  | Create room (hotel_id, name, price_per_night, max_occupancy, available_rooms, rooms_count) |
| GET    | `/api/search`  | Token  | Search availability (query: city, checkin_date, checkout_date, guests) |

**Rate limits**

- Login: 5 requests per minute per IP.
- Other API routes: 60 requests per minute per user (or per IP when unauthenticated).

A Postman collection is provided in `postman/Booking_System_API.postman_collection.json`. Import it and set the `base_url` and `token` variables.

## Testing

Run all tests:

```bash
php artisan test --compact
```

Run only the Search API feature tests:

```bash
php artisan test --compact --filter=ApiSearch
```

## Project structure (high level)

- **Web:** `routes/web.php` → dashboard routes; controllers in `App\Http\Controllers\Dashboard` and `App\Http\Controllers\Auth`.
- **API:** `routes/api.php` → API routes; controllers in `App\Http\Controllers\Api` and `App\Http\Controllers\API` (Auth).
- **Business logic:** `App\Services` (e.g. HotelService, RoomService, UserService), `App\Repositories` for data access.
- **API responses:** `App\Http\Resources` (HotelResource, RoomResource) for JSON.
- **Validation:** `App\Http\Requests` (Form Requests) for web and API.

## License

MIT.
