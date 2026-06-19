# Security Best Practices

## Prevent SQL Injection

Always use parameter binding. Never interpolate user input into queries.

Incorrect:
```php
DB::select("SELECT * FROM users WHERE name = '{$request->name}'");
```

Correct:
```php
User::where('name', $request->name)->get();

// Raw expressions with bindings
User::whereRaw('LOWER(name) = ?', [strtolower($request->name)])->get();
```

## CSRF Protection

Include `@csrf` in all POST/PUT/DELETE Blade forms. In Inertia apps, the `@csrf` directive is automatically applied.

Incorrect:
```blade
<form method="POST" action="/posts">
    <input type="text" name="title">
</form>
```

Correct:
```blade
<form method="POST" action="/posts">
    @csrf
    <input type="text" name="title">
</form>
```

## Rate Limit Auth and API Routes

Apply `throttle` middleware to authentication and API routes.

```php
RateLimiter::for('login', function (Request $request) {
    return Limit::perMinute(5)->by($request->ip());
});

Route::post('/login', LoginController::class)->middleware('throttle:login');
```

## Validate File Uploads

Validate extension, MIME type, and size. The `mimes` rule checks extensions; use `mimetypes` for actual MIME type validation. Never trust client-provided filenames.

```php
public function rules(): array
{
    return [
        'avatar' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
    ];
}
```

Store with generated filenames:

```php
$path = $request->file('avatar')->store('avatars', 'public');
```

## Keep Secrets Out of Code

Never commit `.env`. Access secrets via `config()` only.

Incorrect:
```php
$key = env('API_KEY');
```

Correct:
```php
// config/services.php
'api_key' => env('API_KEY'),

// In application code
$key = config('services.api_key');
```

## Encrypt Sensitive Database Fields

Use `encrypted` cast for API keys/tokens and mark the attribute as `hidden`.

Incorrect:
```php
class Integration extends Model
{
    protected function casts(): array
    {
        return [
            'api_key' => 'string',
        ];
    }
}
```

Correct:
```php
class Integration extends Model
{
    protected $hidden = ['api_key', 'api_secret'];

    protected function casts(): array
    {
        return [
            'api_key' => 'encrypted',
            'api_secret' => 'encrypted',
        ];
    }
}
```
