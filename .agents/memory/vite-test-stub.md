---
name: Vite manifest stub for feature tests
description: Feature tests that render full Blade pages 500 unless a real-enough manifest.json exists.
---

## Rule
Keep `public/build/manifest.json` with valid entries for `resources/css/app.css` and `resources/js/app.js`, plus matching empty stub files in `public/build/assets/`.

**Why:** Laravel's Vite helper throws `ViteManifestNotFoundException` if the manifest is absent, and `ViteException` ("unable to locate file") if the manifest exists but is empty `{}`. Both produce HTTP 500 in feature tests that render HTML pages, masking the actual review/page logic under test.

**How to apply:**
```json
{
  "resources/css/app.css": { "file": "assets/app-stub.css", "isEntry": true, "src": "resources/css/app.css" },
  "resources/js/app.js":  { "file": "assets/app-stub.js",  "isEntry": true, "src": "resources/js/app.js" }
}
```
Also `touch public/build/assets/app-stub.css public/build/assets/app-stub.js`.
This file is already committed in the repo and should not be removed.
