---
name: frontend-conventions
description: Blade templating and design token conventions for this project. Use whenever creating or editing .blade.php files, components, layouts, or writing any Tailwind classes, colors, spacing, or typography in markup.
---

# Frontend Conventions

## Priority
This skill OVERRIDES generic Tailwind examples (including the tailwindcss-development skill) for all visual values. Where that skill shows hardcoded utilities like `bg-gray-900` or `text-gray-900`, use this project's design tokens instead (`bg-surface`, `text-ink`, etc.). Generic Tailwind guidance applies ONLY to layout utilities (flex, grid, gap, positioning) — never to color, spacing, typography, or radius values.

# Blade

## Components
- All components live in `resources/views/components/`, grouped in subfolders by purpose: `ui/`, `layout/`, `sections/`.
- File and component names are kebab-case: `ui/primary-button.blade.php` -> `<x-ui.primary-button>`.
- BEFORE creating a component, check `resources/views/components/` for an existing one and reuse it. Do not create duplicates. (See the design-system skill for the current catalog.)
- Default to anonymous components. Use class-based components only when PHP logic is required.
- Declare inputs with `@props([...])`. Pass extra HTML attributes via `{{ \$attributes->merge([...]) }}`.
- No comments in markup unless the logic is genuinely non-obvious.

## Data
- Templates only display data. Never run Eloquent queries or DB calls inside a Blade file.
- Controllers/actions prepare data and pass it to the view as explicit variables.
- For any repeated structure (cards, menu items, list rows), build a reusable component instead of copy-pasting markup.

# Design Tokens

## Source of Truth
- All design tokens are defined in \`resources/css/app.css\` inside the Tailwind v4 \`@theme\` block.
- Read that file to know the available tokens before styling anything.

## Hard Rule — Tokens Only
- NEVER hardcode raw values. No \`bg-[#2563eb]\`, no \`px-[16px]\`, no inline hex/px, no default Tailwind palette colors (\`bg-gray-900\`, \`text-white\`, etc.).
- Always use the utility classes generated from \`@theme\` tokens: e.g. \`bg-primary\`, \`text-ink\`, \`py-section\`, \`rounded-card\`, \`font-display\`.
- If a needed value has no token, do NOT invent an arbitrary value — add a new token to \`@theme\` first, then use its class.

## Dark Mode
- Do NOT add \`dark:\` variants unless the design explicitly defines a dark theme. Ignore generic guidance that pushes dark mode by default.

## Token Categories (in @theme)
- Colors: \`--color-*\` -> \`bg-*\`, \`text-*\`, \`border-*\`
- Spacing: \`--spacing-*\` -> \`p-*\`, \`m-*\`, \`gap-*\`
- Typography: \`--font-*\`, \`--text-*\`
- Radii: \`--radius-*\` -> \`rounded-*\`

<!--
Token VALUES are filled per project from the design (Figma).
The RULES above are permanent; only the values change between projects.
Example @theme block to fill in resources/css/app.css:

@theme {
  --color-primary: #2563eb;
  --color-on-primary: #ffffff;
  --color-ink: #0f172a;
  --color-surface: #ffffff;
  --spacing-section: 6rem;
  --radius-card: 0.75rem;
  --font-display: "Inter", sans-serif;
}
-->
