# AGENTS.md — Albina Shashkevych Portfolio

This file defines persistent rules for AI agents working in this WordPress theme repository.

The current working directory is already the root of the theme.

Do not create another nested theme directory.

The project is a premium multilingual fashion-photography portfolio for Albina Shashkevych. It should feel like a high-end interactive fashion editorial while remaining fast, accessible, portable and useful for real client work.

---

## 1. Core product principles

The website exists to:

1. create a strong visual impression
2. present work as campaigns/editorials rather than a generic gallery
3. convert brands, agencies, stylists and creative professionals into enquiries

Core experience:

**WOW → TRUST → CONTACT**

Do not turn the site into:

- a generic photographer template
- a basic WordPress portfolio
- a SaaS landing page
- a card-heavy UI
- a masonry gallery with fade-up animations

Photography is the primary visual material.

Typography, layout and motion support the photography.

---

## 2. No build system

This theme must work directly from its source files.

Do not introduce:

- Vite
- Webpack
- Parcel
- Rollup
- Gulp
- npm
- package.json
- Sass/SCSS
- PostCSS
- Tailwind build pipeline
- frontend bundlers
- compiled `dist/` bundles

Use:

- PHP
- semantic HTML
- plain CSS
- plain browser JavaScript
- local static assets

There must be no required frontend compilation step.

A developer should be able to copy the theme folder into WordPress and activate it.

---

## 3. WordPress architecture

Use normal WordPress architecture and APIs.

Do not:

- create a custom router
- replace the template hierarchy
- build the frontend as an SPA
- introduce a page builder
- determine page layouts from hard-coded slugs

Keep `functions.php` lightweight.

Separate responsibilities under `inc/`.

Use hooks, template parts and core WordPress APIs.

---

## 4. Approved plugin stack

Expected plugins:

- Polylang
- Secure Custom Fields (SCF)
- Fluent Forms

Do not introduce additional plugin dependencies without explicit approval or a strong unavoidable reason.

Never add:

- Elementor
- WPBakery
- another page builder
- another custom-field framework
- animation plugins
- jQuery UI plugins

---

## 5. Secure Custom Fields — code-first only

SCF is used for structured project and page content.

All SCF configuration must be **code-first**.

Rules:

- all field groups are registered in PHP inside the theme
- PHP is the single source of truth
- do not rely on manually created SCF groups in WordPress Admin
- use `inc/fields.php` as the registration entry point
- if field definitions become large, split them into `inc/fields/`
- keep field keys and names stable
- never silently rename fields that may contain existing content
- avoid duplicate field definitions

SCF Admin may be used only for inspection/debugging, not as canonical configuration.

Before adding a field, decide whether the data is better represented by:

- core WordPress content
- taxonomy/meta
- SCF structured fields
- an editorial layout block

Do not make everything a custom field by default.

---

## 6. Content model

### Project CPT

Use:

```text
project
```

### Project taxonomy

Use:

```text
project_type
```

A project may belong to multiple types.

Possible terms may include:

- Campaign
- Fashion
- Beauty
- Lookbook
- Editorial

Do not hard-code taxonomy terms into presentation logic when WordPress data can drive the UI.

### Project fields

Projects may include:

- client/project name
- year
- location
- hero media
- short description
- credits
- editorial content blocks

### Credits

Credits support repeatable:

- role
- name
- optional URL

### Editorial blocks

Projects must not be reduced to one generic gallery.

The architecture should support reusable blocks such as:

- fullscreen image
- portrait image
- two-column images
- three-image composition
- image + text
- sticky image sequence
- horizontal image strip
- video
- editorial text
- credits

Keep block rendering modular.

Do not place all rendering logic directly inside `single-project.php`.

---

## 7. Selectable Page Templates

Special pages must use actual WordPress Page Templates.

Do not create special layouts tied to slugs.

Expected templates:

```text
templates/template-about.php
templates/template-for-brands.php
templates/template-contact.php
templates/template-pitch.php
templates/template-deck.php
```

Every special template must include a proper WordPress `Template Name` header.

Keep:

```text
page.php
404.php
```

as general fallbacks.

### About

Supports:

- portrait/profile media
- concise biography/positioning
- selected credentials/facts
- optional CTA

### For Brands

Supports editable commercial content such as:

- campaigns
- lookbooks
- beauty
- editorial/commercial fashion
- social campaign content
- selected work
- enquiry CTA

Do not hard-code service names when they should be editable.

### Contact

Fluent Forms handles form processing.

The theme handles layout and styling only.

Do not build a parallel custom form backend.

### Brand Pitch

`template-pitch.php` is reusable for targeted outreach.

Examples:

- Albina × MD Fashion
- Albina × Rhode
- Albina × another brand

Never create one PHP template per brand.

Drive Pitch content through WordPress/SCF data.

It may support:

- custom hero
- pitch title
- intro/proposition
- selected projects
- standalone imagery
- editorial copy
- optional proposal/services
- CTA

### Deck

`template-deck.php` is a reusable portfolio/media-deck page for brands, agencies and art directors.

Keep it structured and data-driven.

---

## 8. Multilingual rules

The site supports:

- Ukrainian
- English
- Russian

Use Polylang.

All theme UI strings must use WordPress localization functions.

Do not hard-code translated interface strings directly into templates.

Use `wpml-config.xml` where useful for field translation/copy behavior.

Prefer shared/copied data for:

- media
- year
- some credits
- layout configuration

Prefer separately translated data for:

- titles
- descriptions
- editorial copy
- CTA text
- service descriptions

Never infer special template behavior from translated page slugs.

---

## 9. Frontend stack

Use only:

- semantic HTML
- plain CSS
- modern vanilla JavaScript
- local vendor assets

Do not use:

- jQuery
- React
- Vue
- Svelte
- CSS preprocessors
- build tools
- public-CDN project dependencies
- large UI frameworks

Keep dependencies intentional and minimal.

---

## 10. GSAP

GSAP is the main motion engine.

It must be stored locally inside the theme, expected under:

```text
assets/vendor/gsap/
```

Potential files:

```text
gsap.min.js
ScrollTrigger.min.js
Flip.min.js
SplitText.min.js
```

Load libraries through `wp_enqueue_script()`.

Do not depend on npm.

Do not depend on a public CDN unless explicitly requested later.

If the actual GSAP files are absent:

- create the expected vendor directory
- prepare clean enqueue logic
- do not fake or recreate GSAP source
- report which vendor files are missing

---

## 11. Asset loading

Use WordPress enqueue APIs:

- `wp_enqueue_style()`
- `wp_enqueue_script()`
- supported script loading strategy APIs when useful

Do not manually hard-code asset tags in templates when enqueue APIs are appropriate.

Keep script dependency order explicit:

1. GSAP core
2. GSAP plugins
3. animation scripts
4. general theme scripts

Do not add a bundler to solve dependency ordering.

---

## 12. JavaScript architecture without bundling

Browser JavaScript files are loaded directly from the theme.

Animation files should remain modular by responsibility.

Suggested structure:

```text
assets/js/
├── app.js
├── animations/
│   ├── flash.js
│   ├── mask-reveal.js
│   ├── split-text.js
│   ├── image-expand.js
│   ├── project-preview.js
│   └── sticky-gallery.js
└── components/
```

Each file should:

- keep local scope through an IIFE or equivalent
- avoid arbitrary globals
- fail gracefully if its target DOM is absent
- fail gracefully if GSAP is unavailable
- initialize only its own behavior
- avoid duplicated listeners and initialization

If shared state is genuinely needed, use at most one controlled namespace:

```js
window.AlbinaTheme
```

Do not create many global variables.

---

## 13. Motion design system

Motion is central to the art direction.

Do not default to generic fade-up effects.

Prefer reusable hooks such as:

```html
data-motion="flash-in"
data-motion="mask-reveal"
data-motion="split-text"
data-motion="image-expand"
data-motion="project-preview"
data-motion="sticky-gallery"
```

Never tie reusable motion code to a specific project name.

Bad:

```js
gsap.to('.rhode-image', ...)
```

Good:

```html
<div data-motion="image-expand">
```

### Motion vocabulary

May include:

- flash/shutter transitions
- mask reveals
- kinetic typography
- image expansion
- project previews
- sticky editorial sequences
- controlled parallax
- horizontal tracks

Motion must support editorial rhythm.

Avoid:

- gratuitous movement
- animation on every element
- aggressive scroll hijacking
- long fake loading screens
- effects that reduce usability

---

## 14. Accessibility

Accessibility is required.

Always support:

```css
@media (prefers-reduced-motion: reduce)
```

Reduced-motion users receive a complete usable experience.

Do not:

- hide essential content behind animation
- make required actions hover-only
- remove useful focus states
- use clickable `<div>` elements instead of links/buttons

Use semantic HTML and correct heading hierarchy.

---

## 15. Responsive behavior

Mobile is not a smaller desktop.

Design touch interactions intentionally.

Desktop hover interactions need mobile alternatives.

Avoid cursor-driven effects on touch devices.

Do not assume viewport height is fixed on mobile.

Consider:

- narrow mobile
- large mobile
- tablet
- laptop
- large desktop

---

## 16. Images and media

Use WordPress media APIs.

Prefer:

- `wp_get_attachment_image()`
- responsive `srcset`
- correct `sizes`
- width/height attributes
- intentional loading behavior

Avoid raw full-size image URLs when attachment functions are appropriate.

Hero media may load eagerly when justified.

Below-the-fold imagery should generally lazy-load.

Avoid CLS.

Create custom image sizes only when useful.

---

## 17. CSS architecture

Use plain CSS only.

No SCSS/Sass.

Suggested structure:

```text
assets/css/
├── variables.css
├── base.css
├── layout.css
├── components.css
├── pages.css
└── motion.css
```

Use CSS custom properties for reusable tokens:

- spacing
- typography
- container widths
- z-index layers
- motion durations/easings

Avoid:

- excessive specificity
- deep selector chains
- `!important` as a default fix
- hundreds of random magic values
- styling tied to random WordPress-generated IDs

The CSS source files themselves are production files.

There is no compilation stage.

---

## 18. PHP quality

Follow modern WordPress practices.

Requirements:

- escape frontend output
- sanitize input where applicable
- use nonces for state-changing actions
- use hooks properly
- use core APIs
- keep `functions.php` lightweight
- avoid unnecessary DB queries
- use `WP_Query` correctly
- reset post data
- keep templates readable
- move repeated markup to template parts
- do not suppress errors as a fix
- do not use deprecated APIs

---

## 19. Theme structure

Preferred structure:

```text
theme-root/
├── assets/
│   ├── css/
│   ├── js/
│   │   ├── animations/
│   │   └── components/
│   ├── images/
│   └── vendor/
│       └── gsap/
│
├── inc/
│   ├── setup.php
│   ├── post-types.php
│   ├── taxonomies.php
│   ├── fields.php
│   ├── fields/
│   ├── polylang.php
│   ├── assets.php
│   └── helpers.php
│
├── template-parts/
│   ├── global/
│   ├── home/
│   ├── project/
│   └── components/
│
├── templates/
│   ├── template-about.php
│   ├── template-for-brands.php
│   ├── template-contact.php
│   ├── template-pitch.php
│   └── template-deck.php
│
├── functions.php
├── front-page.php
├── archive-project.php
├── single-project.php
├── page.php
├── 404.php
├── header.php
├── footer.php
├── style.css
├── wpml-config.xml
├── screenshot.png
└── README.md
```

This may evolve for a concrete reason.

Do not casually restructure the whole repository.

Never introduce a `dist/` build architecture.

---

## 20. Performance

Visual ambition does not justify poor performance.

Avoid:

- unnecessary JavaScript
- duplicate libraries
- heavy autoplay media without reason
- expensive continuous scroll handlers
- excessive DOM complexity
- oversized images

Prefer transforms/opacity for animation when practical.

Be conscious of:

- LCP
- CLS
- INP
- image payload
- mobile performance

Do not introduce a build system as a performance fix.

Use clean source files and WordPress/hosting-level caching/optimization where appropriate.

---

## 21. Header and navigation

Keep navigation minimal and editorial.

The implementation should support:

- Work
- About
- For Brands
- Contact
- language switcher

Do not hard-code page URLs if WordPress/Polylang APIs can resolve them.

---

## 22. Forms

Use Fluent Forms.

The theme may:

- style forms
- provide wrappers
- provide layout/context

Do not duplicate form-processing logic.

Do not assume Pro-only fields are available unless explicitly confirmed.

---

## 23. Working with existing code

Before changes:

1. inspect the repository
2. understand current conventions
3. identify existing dependencies
4. preserve useful work
5. avoid deleting code only to rewrite it in a preferred style

Do not overwrite working architecture without a concrete reason.

Preserve compatibility with existing content where practical.

---

## 24. Agent workflow

For substantial tasks:

1. inspect relevant files first
2. identify the smallest coherent implementation
3. change files incrementally
4. keep architecture consistent with this document
5. run available PHP/static checks where possible
6. review obvious browser-facing JS issues
7. summarize changes accurately

Possible checks include:

- PHP syntax checks
- confirming enqueued file paths exist
- checking duplicate hooks
- checking missing template parts
- checking expected vendor assets

There is no frontend build command.

Do not add one.

Never claim something was tested if it was not.

---

## 25. Change discipline

Do not:

- add unrelated features
- install extra plugins
- add libraries merely for convenience
- add npm
- add a bundler
- add SCSS
- rewrite working files unnecessarily
- create duplicate helpers
- duplicate field groups
- hard-code real production content
- invent fake clients
- add a second animation system
- create slug-specific special page templates

If something is deferred, leave a concise note instead of building a speculative system.

---

## 26. Documentation

Keep README updated when changing:

- required plugins
- theme structure
- vendor assets
- manual WordPress setup
- important architecture decisions

Do not document build commands because the theme has no build process.

If local GSAP files must be added manually, document their expected paths clearly.

---

## 27. Visual direction

The site should feel closer to:

- a digital fashion editorial
- a creative-direction presentation
- a premium campaign experience

Use:

- strong typography
- whitespace
- asymmetry
- large photography
- controlled overlap
- editorial rhythm
- selective motion

Avoid:

- card-heavy layouts
- rounded SaaS UI patterns
- generic galleries as the main experience
- random trendy effects unrelated to the photography

The motion language should feel intentional and consistent.

---

## 28. Final rule

When an explicit task requirement conflicts with this file, follow the explicit task for that request while preserving as much of this architecture as possible.

If a requested change creates a significant architectural tradeoff, explain it in the implementation summary rather than silently introducing it.
