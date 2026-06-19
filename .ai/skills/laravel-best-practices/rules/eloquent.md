# Eloquent Best Practices

## Use Correct Relationship Types

Use `hasMany`, `belongsTo`, `morphMany`, etc. with proper return type hints.

```php
/** @return HasMany<Comment, $this> */
public function comments(): HasMany
{
    return $this->hasMany(Comment::class);
}

/** @return BelongsTo<User, $this> */
public function author(): BelongsTo
{
    return $this->belongsTo(User::class, 'user_id');
}
```

## Use Local Scopes for Reusable Queries

Extract reusable query constraints into local scopes to avoid duplication.

Incorrect:
```php
$active = User::where('verified', true)->whereNotNull('activated_at')->get();
$articles = Article::whereHas('user', function ($q) {
    $q->where('verified', true)->whereNotNull('activated_at');
})->get();
```

Correct:
```php
public function scopeActive(Builder $query): Builder
{
    return $query->where('verified', true)->whereNotNull('activated_at');
}

// Usage
$active = User::active()->get();
$articles = Article::whereHas('user', fn ($q) => $q->active())->get();
```

## Define Attribute Casts

Use the `casts()` method (or `$casts` property following project convention) for automatic type conversion.

```php
protected function casts(): array
{
    return [
        'is_active' => 'boolean',
        'metadata' => 'array',
        'total' => 'decimal:2',
    ];
}
```

## Use `whereBelongsTo()` for Relationship Queries

Cleaner than manually specifying foreign keys.

Incorrect:
```php
Post::where('user_id', $user->id)->get();
```

Correct:
```php
Post::whereBelongsTo($user)->get();
Post::whereBelongsTo($user, 'author')->get();
```

## Avoid Hardcoded Table Names in Queries

Never use string literals for table names in raw queries, joins, or subqueries. Hardcoded table names make it impossible to find all places a model is used and break refactoring (e.g., renaming a table requires hunting through every raw string).

Incorrect:
```php
DB::table('users')->where('active', true)->get();

$query->join('companies', 'companies.id', '=', 'users.company_id');

DB::select('SELECT * FROM orders WHERE status = ?', ['pending']);
```

Correct — reference the model's table:
```php
DB::table((new User)->getTable())->where('active', true)->get();

// Even better — use Eloquent or the query builder instead of raw SQL
User::where('active', true)->get();
Order::where('status', 'pending')->get();
```

Prefer Eloquent queries and relationships over `DB::table()` whenever possible — they already reference the model's table. When `DB::table()` or raw joins are unavoidable, always use `(new Model)->getTable()` to keep the reference traceable.

**Exception — migrations:** In migrations, hardcoded table names via `DB::table('settings')` are acceptable and preferred. Models change over time but migrations are frozen snapshots — referencing a model that is later renamed or deleted would break the migration.
