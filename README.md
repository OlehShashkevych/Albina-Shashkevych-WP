# Albina Shashkevych — WordPress theme

A portable, image-led fashion portfolio. PHP, plain CSS and browser JavaScript are the production files. Copy this directory directly into `wp-content/themes/` and activate it. There is no compilation step, package manager, generated bundle or external frontend dependency request.

## Requirements and setup

- WordPress 6.4+ and PHP 8.0+.
- **Secure Custom Fields** for structured content (the WordPress.org plugin, not the unrelated Smart Custom Fields). Groups are registered only in `inc/fields.php` and `inc/fields/`. SCF exposes the `acf_*` PHP API; no ACF installation is required.
- **Polylang** for Ukrainian, English and Russian pages, projects, taxonomy terms and menus.
- **Fluent Forms** for contact form processing. Free features are sufficient; the theme has no form backend.

1. Activate the theme; set the Site Title to `Albina Shashkevych` and the tagline to the desired positioning. Theme activation flushes permalink rules once. If deployment replaces an already active theme, visit **Settings → Permalinks → Save** once to register `/work/`.
2. Install/activate the three plugins. In Polylang, add Ukrainian (`uk`), English (`en`) and Russian (`ru`). Assign a language to existing content. Translate Projects and Project types; no terms or sample clients are created automatically.
3. Create a Home page and select it in **Settings → Reading → A static page**. Translate and link the home pages in Polylang. Fill its opening image, short introduction, ordered selected projects and optional CTA. If no projects are selected, the six latest published projects in the current language appear. The page editor can supply additional introductory content.
4. Create pages using selectable templates: **About**, **For Brands**, **Contact**, **Brand Pitch**, **Portfolio Deck**. Page title is the presentation/pitch title; the core editor is biography, proposition or body copy. Slugs are unrestricted. Add translations and assign the same template to each language version.
5. Create a Primary navigation menu for each language with Work (the project archive), About, For Brands and Contact. Without a menu, the theme resolves published pages by their assigned templates. Language links omit unavailable translations.
6. Add projects, project types and responsive media. Featured image is the fallback for the hero field. Use the core excerpt or Short introduction for the project description. Fill client, year, location, credits and editorial blocks as needed.
7. Configure About credentials; For Brands services and selected projects; Pitch/Deck selected projects, standalone imagery/editorial blocks and optional proposals. These selections are omitted when empty; unrelated projects are not substituted.
8. Create and configure a Fluent Forms form (including recipients, spam protection and confirmation) and enter its numeric ID on Contact. Alternatively, leave the ID empty and insert the plugin’s block/shortcode in the page editor. Add the optional public email as a fallback contact route. Avoid adding both form placements. Create a form for each language and set its ID on that translated Contact page.
9. GSAP is bundled locally and motion is ready. Upload real photography and set alt text in the Media Library. No demo photography, invented clients or production project copy is bundled.

## Structure

- `functions.php`: module loading only.
- `inc/`: theme setup, CPT/taxonomy registration, enqueue logic, SCF definitions, helpers and Polylang support.
- `assets/css/`: variables, base, layout, components, pages and motion; loaded in that order.
- `assets/js/animations/`: motion bootstrap and independent hook-based effects. `app.js` initializes navigation and motion after the modules register.
- `template-parts/home/`: opening, editorial selection and typography-led index.
- `template-parts/project/blocks/`: ten allowlisted SCF layouts: fullscreen, portrait, pair, triptych, image/text, sticky sequence, horizontal strip, video, editorial text and credits.
- `templates/`: five selectable Page Templates. Pitch and Deck share presentation markup while retaining separate WordPress template identities.
- `archive-project.php`, `taxonomy-project_type.php`, `single-project.php`: native WordPress project routes. Taxonomy filtering is navigable without JavaScript; archives use the main paginated query.
- `page.php`, `index.php`, `404.php`: standard fallbacks.
- `languages/`: frontend Ukrainian and Russian catalogs; English is the source language.
- `screenshot.png`: the theme’s typography-only opening preview for Appearance → Themes.

## Local GSAP integration

Bundled, unchanged **GSAP 3.15.0** from the official repository:

```text
assets/vendor/gsap/gsap.min.js
assets/vendor/gsap/ScrollTrigger.min.js
assets/vendor/gsap/Flip.min.js
assets/vendor/gsap/SplitText.min.js
```

Source commit, file checksums and license link are recorded in `assets/vendor/gsap/README.md`. Vendor copyright/license headers are preserved. No CDN, npm or additional plugin is required.

`inc/assets.php` registers assets without downloading them to the visitor. Each rendered template part calls `albina_enqueue_motion()` for its effect. WordPress resolves core/plugin dependencies; the app is enqueued at `wp_footer` priority 5 with only the requested effects as dependencies, before WordPress prints footer scripts. For example, 404 loads only navigation, About adds GSAP/SplitText, a selection of project covers adds Flip, and editorial masks/sticky sequences add ScrollTrigger. Missing vendor files disable only the dependent effect.

Core enables the short shutter entrance and kinetic headings; SplitText adds word-level movement. ScrollTrigger enables masks and desktop sticky sequences. On a normal project-cover click, Flip expands a decorative copy of the displayed image to the viewport over 0.45 seconds and follows the original link with native navigation. Modified clicks, new tabs, downloads, unavailable images/libraries and reduced motion retain normal link behavior. Back navigation clears the overlay. No SPA router or Ajax page replacement is involved. Horizontal strips use native scrolling, including keyboard access. No autoplay video or scroll interception.

All content is visible in the baseline CSS. Reduced motion disables motion and cleans up via GSAP matchMedia when the preference changes. Pointer previews only activate on wide screens with a fine pointer; touch/narrow layouts display inline thumbnails. Navigation works without JavaScript, and the mobile menu is enhanced progressively.

## Translation and content safety

UI strings use the `albina` text domain. Included `uk` and `ru_RU` catalogs cover the frontend; WordPress uses the visitor locale selected by Polylang. Editor labels remain translatable through standard gettext catalogs. Update catalogs if UI strings change.

Creating a translation through Polylang copies this theme’s SCF data once: editorial layouts, images, nested credits, facts, services, project selections, opening fields and crop settings, including private SCF field-key references. Source-language text is copied as a starting point to translate, not machine-translated. Core title/body translation remains Polylang’s responsibility. Review copied CTA URLs and form IDs for the target language.

`inc/polylang.php` uses `pll_copy_post_metas` to exclude theme fields from subsequent synchronization, even if blanket custom-field synchronization is enabled. Existing target fields are preserved; an existing repeater/flexible-content tree is protected as a whole, including partially populated trees. No existing translations are migrated or backfilled automatically. Other plugins’ metadata is unaffected. `wpml-config.xml` keeps the page template shared and records copy-once media/crop/year preferences. Media attachment IDs are shared; translate attachment alt text separately if needed. Selected projects use available target-language IDs, retaining unresolved source IDs so the frontend can resolve translations created later; unpublished/untranslated selections remain omitted from the frontend.

## Image framing

Opening-image fields now include an optional mobile image and desktop/mobile horizontal/vertical focus controls: **0%** is left/top, **50%** is center, **100%** is right/bottom. These set `object-position` wherever the design crops an image; they do not crop or modify the uploaded original. Existing images remain centered until adjusted. Uncropped portrait layouts continue to show the full image.

Projects also have an optional **Project cover image** plus separate cover mobile image and focus controls. These affect selected work, archives and project-index thumbnails independently of the single-project hero. If the cover image is empty, it uses the hero/featured image; its mobile source falls back to the hero’s mobile image. A custom cover without a mobile version uses that custom cover at every width.

`albina_art_directed_image()` renders native `<picture>`/`<source>` with WordPress image sources, srcsets and dimensions. Up to 760px the browser selects the mobile source; larger screens use the desktop source. Focus settings can differ on mobile even when both use the same image. Mobile alternatives should depict the same subject, as the fallback image’s alt text describes both sources. Invalid/missing mobile media falls back to the desktop image. Without SCF, featured images continue to work.

SCF keys and names are stable and defined once. Do not create duplicate groups in the SCF UI. Without SCF, custom sections are omitted and core titles, content, excerpts and featured images remain available. Without Polylang, the theme works as a single-language site. Without Fluent Forms, no theme form is simulated; any configured public email remains visible. Protected pages must not expose structured content before password entry.

Video blocks accept local MP4/WebM attachments with controls and a poster. For spoken content, supply a hosted WebVTT caption URL and a transcript in the page language. The theme does not alter WordPress upload security to permit VTT uploads.

## Validation / deployment

Before deployment, lint changed PHP files with `php -l` and JavaScript with `node --check` (validation tools only; neither is needed to serve the theme). Verify SCF keys, layout renderers and enqueue paths. There is no frontend compilation command.

After activation on the actual WordPress site, verify all three languages, SCF editing/saving, menu routes, media crops, pagination, mobile navigation, keyboard focus, reduced motion and a real Fluent Forms submission/email. Local checks cannot establish hosting configuration, mail delivery, Polylang/SCF plugin interoperability or live deployment success.

Initial local verification: 45 PHP files and 8 JavaScript files passed syntax checks; XML and both MO catalogs parsed successfully. An isolated PHP fixture exercised 36 template/data combinations, including absent SCF and password protection, and checked unique field keys, block files and asset dependencies. Headless Edge checked nine layouts at 320, 390, 768, 1366 and 1920 pixels, plus mobile menu/Escape/focus, navigation without JavaScript and reduced-motion CSS. No horizontal document overflow or page JavaScript errors were found. Fixture files and test images stay in ignored `.qa/` and are not deployed. These are fixture checks, not a live WordPress integration test.

Version 1.1 local verification: 24 fixture renders checked the changed templates, field keys and asset dependencies. Translation tests covered nested/private SCF metadata, existing and partial target trees, repeated copy, blanket synchronization and project-ID mapping. Headless Edge exercised the actual bundled GSAP libraries, Flip navigation, modified clicks, back navigation, reduced-motion cleanup, missing-core fallback, conditional script requests, mobile image selection and focal positions; 15 responsive layout checks passed at 320–1920px without page JavaScript errors. Server/admin integration remains a separate manual check. No CI or deployment pipeline was added.

API references: [SCF local field registration](https://developer.wordpress.org/secure-custom-fields/code-reference/local-fields-file/) and [Polylang wpml-config.xml behavior](https://polylang.pro/documentation/support/developers/the-wpml-config-xml-file/).
