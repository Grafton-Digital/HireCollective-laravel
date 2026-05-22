## Project
MVP built with Laravel + Blade + Filament. Small budget, fast iteration. Self-hosted on a single VPS.

## Stack
- Framework: Laravel (latest stable)
- Templating: Blade (server-side rendered HTML, components in resources/views/components)
- Admin panel: Filament (for the founder/admin role only — not for boutique dashboards)
- Database: PostgreSQL
- ORM: Eloquent
- Auth: Laravel Breeze (Blade stack)
- Migrations: PHP files in database/migrations
- Frontend interactivity: minimal — Alpine.js for small interactions, Livewire only if a feature genuinely needs it. No SPA framework.

## Rules
1. Authorization is enforced through Laravel Policies, registered in AuthServiceProvider. Every model that holds user data MUST have a Policy with explicit methods (viewAny, view, create, update, delete) and route-level authorization via middleware or controller authorize() calls. Policies are created in the same change as the model — never deferred.
2. No secrets in code, ever. Use .env and config/ files. APP_KEY and database credentials never appear in any committed file.
3. Migrations move forward only. To change schema, write a new migration — never edit an applied one. Each migration is its own file. Use Schema::table() for additive changes.
4. Before generating or modifying code, always show a plan first (file list and intent) and wait for my confirmation.
5. Work in small increments — one feature or one logical unit per pass, not large multi-feature batches.
6. Server-side rendering is the default. Public pages (homepage, boutique pages, product pages, search results) MUST render as full HTML on the server for SEO. Reach for Livewire or Alpine only when interactivity genuinely requires it.
7. Use Eloquent relationships, form requests for validation, and resource controllers where they fit. Don't bypass framework conventions without a reason.
8. When something is ambiguous, ask rather than assume.
