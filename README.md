## Localhost Deploy

- Copy `.env.local` to `.env`.
- Execute `composer install` from root path.
- Change folder permissions `sudo chmod -R 777 storage bootstrap/cache` from root path.

## URL Request Test

- Execute `php artisan serve` from root path and keep the terminal opened.
- Put in web browser `localhost:8000/users/send_notification/{user_id}` and search.
- Example: [localhost:8000/users/send_notification/1](http://localhost:8000/users/send_notification/1)
- Only 1 to 3 user IDs exists.

## Command Execution Test

- Execute `php artisan command:send-notification {user_id}` from root path.
- Only 1 to 3 user IDs exists.