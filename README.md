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
9. Add genuine local GSAP vendor files listed below to enable motion. Upload real photography and set alt text in the Media Library. No demo photography, invented clients or production project copy is bundled.

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

Not supplied in this repository:

```text
assets/vendor/gsap/gsap.min.js
assets/vendor/gsap/ScrollTrigger.min.js
assets/vendor/gsap/Flip.min.js
assets/vendor/gsap/SplitText.min.js
```

Supply matching official distribution versions (core 3.11+), preserving license notices. The enqueue layer checks every file. Core precedes plugins, bootstrap precedes effect modules, and `app.js` loads last. No missing vendor path is requested.

Core enables the short shutter entrance and kinetic headings. ScrollTrigger enables masks, progressive image reveals and desktop sticky sequences. SplitText optionally adds word-level movement; headings otherwise animate as a whole. Flip is registered when supplied; `data-flip-id` is a foundation for future shared-element transitions, not a router or implemented inter-page transition. Horizontal strips use native scrolling, including keyboard access. No autoplay video or scroll interception.

All content is visible in the baseline CSS. Reduced motion disables motion and cleans up via GSAP matchMedia when the preference changes. Pointer previews only activate on wide screens with a fine pointer; touch/narrow layouts display inline thumbnails. Navigation works without JavaScript, and the mobile menu is enhanced progressively.

## Translation and content safety

UI strings use the `albina` text domain. Included `uk` and `ru_RU` catalogs cover the frontend; WordPress uses the visitor locale selected by Polylang. Editor labels remain translatable through standard gettext catalogs. Update catalogs if UI strings change.

`wpml-config.xml` copies shared top-level hero media/year/template/email and marks short text, CTA and form ID for independent translation. Polylang treats `translate` like copy-once; this does not perform automatic translation. **Do not enable blanket custom-field synchronization**: nested editorial content, services, facts, credits and project selections are maintained per language to avoid overwriting translated copy or mismatching repeater rows. Reuse the same Media Library attachments and credit names as appropriate. Review selected project links in each language; the renderer resolves linked translations and omits untranslated/private selections.

SCF keys and names are stable and defined once. Do not create duplicate groups in the SCF UI. Without SCF, custom sections are omitted and core titles, content, excerpts and featured images remain available. Without Polylang, the theme works as a single-language site. Without Fluent Forms, no theme form is simulated; any configured public email remains visible. Protected pages must not expose structured content before password entry.

Video blocks accept local MP4/WebM attachments with controls and a poster. For spoken content, supply a hosted WebVTT caption URL and a transcript in the page language. The theme does not alter WordPress upload security to permit VTT uploads.

## Validation / deployment

Before deployment, lint changed PHP files with `php -l` and JavaScript with `node --check` (validation tools only; neither is needed to serve the theme). Verify SCF keys, layout renderers and enqueue paths. There is no frontend compilation command.

After activation on the actual WordPress site, verify all three languages, SCF editing/saving, menu routes, media crops, pagination, mobile navigation, keyboard focus, reduced motion and a real Fluent Forms submission/email. Vendor animation behavior requires the genuine GSAP files. Local static checks cannot establish hosting configuration, mail delivery, Polylang/SCF plugin interoperability or live deployment success.

Initial local verification: 45 PHP files and 8 JavaScript files passed syntax checks; XML and both MO catalogs parsed successfully. An isolated PHP fixture exercised 36 template/data combinations, including absent SCF and password protection, and checked unique field keys, block files and asset dependencies. Headless Edge checked nine layouts at 320, 390, 768, 1366 and 1920 pixels, plus mobile menu/Escape/focus, navigation without JavaScript and reduced-motion CSS. No horizontal document overflow or page JavaScript errors were found. Fixture files and test images stay in ignored `.qa/` and are not deployed. These are fixture checks, not a live WordPress integration test.

API references: [SCF local field registration](https://developer.wordpress.org/secure-custom-fields/code-reference/local-fields-file/) and [Polylang wpml-config.xml behavior](https://polylang.pro/documentation/support/developers/the-wpml-config-xml-file/).
