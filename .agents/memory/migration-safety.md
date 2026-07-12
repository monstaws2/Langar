---
name: Migration safety patterns
description: How to handle duplicate-column and empty-stub migrations without breaking fresh installs or tests.
---

## Rule
Any migration that adds a column or table which might already exist (e.g. created in a prior monolithic migration) must guard with `Schema::hasColumn` / `Schema::hasTable` before acting. Empty stub migrations must be filled in — an empty body silently skips the intended schema change.

**Why:** The orders table migration (`101500`) created `order_items`, `province`, and `order_number` inline. Later migrations that tried to add those same columns failed on fresh SQLite installs with "duplicate column" errors. The `add_deleted_at_to_products` migration was generated as an empty stub, causing `SoftDeletes` queries to fail in tests with "no such column: deleted_at".

**How to apply:**
- When writing an additive migration, wrap the body: `if (!Schema::hasColumn('table', 'col')) { ... }`.
- After generating a migration stub, verify the `up()` body is non-empty before committing.
- In `down()`, also guard: `if (!Schema::hasColumn('table', 'col')) { return; }`.
