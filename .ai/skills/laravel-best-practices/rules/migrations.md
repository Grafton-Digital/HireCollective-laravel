# Migration Best Practices

## Generate Migrations with Artisan

Always use `php artisan make:migration` for consistent naming and timestamps.

Incorrect (manually created file):
```php
// database/migrations/posts_migration.php  ← wrong naming, no timestamp
```

Correct (Artisan-generated):
```bash
php artisan make:migration create_posts_table
php artisan make:migration add_slug_to_posts_table
```

## Use `constrained()` for Foreign Keys

Automatic naming and referential integrity.

```php
$table->foreignId('user_id')->constrained()->cascadeOnDelete();

// Non-standard names
$table->foreignId('author_id')->constrained('users');
```

## Mirror Defaults in Model `$attributes`

When a column has a database default, mirror it in the model so new instances have correct values before saving.

```php
// Migration
$table->string('status')->default('pending');

// Model
protected $attributes = [
    'status' => 'pending',
];
```

## Write Reversible `down()` Methods by Default

Implement `down()` for schema changes that can be safely reversed so `migrate:rollback` works in CI and failed deployments.

```php
public function down(): void
{
    Schema::table('posts', function (Blueprint $table) {
        $table->dropColumn('slug');
    });
}
```

For intentionally irreversible migrations (e.g., destructive data backfills), leave a clear comment and require a forward fix migration instead of pretending rollback is supported.

## Keep Migrations Focused

One concern per migration. Never mix DDL (schema changes) and DML (data manipulation).

Incorrect (partial failure creates unrecoverable state):
```php
public function up(): void
{
    Schema::create('settings', function (Blueprint $table) { ... });
    DB::table('settings')->insert(['key' => 'version', 'value' => '1.0']);
}
```

Correct (separate migrations):
```php
// Migration 1: create_settings_table
Schema::create('settings', function (Blueprint $table) { ... });

// Migration 2: seed_default_settings
DB::table('settings')->insert(['key' => 'version', 'value' => '1.0']);
```
