---
name: PHP version for this repo
description: Replit defaults to PHP 8.2 but Laravel 13 (and symfony/http-foundation 8.1+) requires 8.3+/8.4+.
---

## Rule
Before running `composer install/update` or any `artisan` command, ensure PHP 8.4 is active.

**Why:** Replit's default module is `php-8.2`. Laravel 13 requires `php ^8.3`, and `symfony/http-foundation v8.1` uses PHP 8.4 property-hook syntax (`public T $prop { set { ... } }`), which causes a parse error on 8.2.

**How to apply:**
1. `await installProgrammingLanguage({ language: "php-8.4" })` via CodeExecution.
2. Update `composer.json`: `.require.php = "^8.2|^8.3|^8.4"`, `.config.platform = { "php": "8.4.0" }` (use `jq`).
3. Then run `composer update --no-interaction --prefer-dist`.
