# Local GSAP distribution

Bundled GSAP **3.15.0**, downloaded unchanged from the [official repository](https://github.com/greensock/GSAP/tree/13e2b790546426a1a2e0e9b409f3f8dc6d6611f2/dist), commit `13e2b790546426a1a2e0e9b409f3f8dc6d6611f2`.

All copyright/license headers are preserved. GSAP is third-party software under its [Standard License](https://gsap.com/standard-license/), separate from the theme PHP/CSS license. These files are served locally; visitors make no CDN requests.

- `gsap.min.js` — SHA-256 `92bb9a96476f983d212a2bc4f54c889039c1696dd4461d40a736860938570fbb`
- `ScrollTrigger.min.js` — SHA-256 `b0b14d67b55b0c43c756ac0b106cfcb09d0879945f6ead64451065b0672916a2`
- `Flip.min.js` — SHA-256 `cbe3ca726350f8d230da38a14ce2384e7772e05a45cee6144dd7fe6dde868c2f`
- `SplitText.min.js` — SHA-256 `419f7027a5f086a12cb7988736d8fdd3a6ed2200229661de25b6628ca7ced344`

Core supports the effects. ScrollTrigger is requested only by mask reveals and sticky sequences; Flip only by clickable project covers; SplitText only by kinetic headings. The matching theme parts enqueue their effect, and WordPress resolves dependencies. If a required library is removed, that effect is skipped; essential content and links remain usable.
