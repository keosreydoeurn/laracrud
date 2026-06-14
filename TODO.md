# TODO - Make Laravel+Vue CRUD work

## Step 1: Fix database config
- [x] Hardcode `config/database.php` -> `connections.mysql` (host 127.0.0.1, port 3307, database laravel_vue_crud, username root).
- [x] Run: `php artisan optimize:clear` (attempted earlier)
- [x] Run: `php artisan config:clear`
- [x] Run: `php artisan cache:clear`

## Step 2: Test Database Connection
- [x] Run: `php artisan tinker` and verified PDO connection.

## Step 3: Run migrations
- [x] Run: `php artisan migrate:fresh --force`

## Step 4: Start dev servers
- [ ] Run backend: `php artisan serve`
- [ ] Run frontend: `npm run dev`

## Step 5: Verify CRUD endpoints
- [ ] Check browser loads `/`
- [ ] Test create/update/delete from UI


