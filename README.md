# OT FAQ — TYPO3 FAQ Extension with Structured Data

A FAQ extension for TYPO3 v13 that renders an accessible Bootstrap 5 accordion and automatically outputs valid *
*Schema.org FAQPage JSON-LD** structured data for Google Rich Results.

[![TYPO3](https://img.shields.io/badge/TYPO3-13.4-orange.svg)](https://typo3.org/)
[![Packagist Version](https://img.shields.io/packagist/v/oliverthiele/ot-faq.svg)](https://packagist.org/packages/oliverthiele/ot-faq)
[![PHP](https://img.shields.io/packagist/dependency-v/oliverthiele/ot-faq/php.svg)](https://php.net/)
[![License](https://img.shields.io/packagist/l/oliverthiele/ot-faq.svg)](LICENSE)
[![Changelog](https://img.shields.io/badge/Changelog-CHANGELOG.md-blue.svg)](CHANGELOG.md)

---

## Features

- **Schema.org FAQPage** — JSON-LD structured data generated automatically from question/answer records
- **Bootstrap 5 accordion** — accessible, animated, with configurable initial state (first open / all closed)
- **Restricted RTE** — custom CKEditor preset (`OtFaqAnswer`) limits the answer editor to HTML tags allowed by Google's
  FAQ structured data specification
- **Custom parseFunc** — `lib.parseFuncOtFaqAnswer` additionally strips disallowed tags on frontend output
- **ot-irrebuttons integration** — when `oliverthiele/ot-irrebuttons` is installed, each question can have individual
  buttons (icon, label, link) instead of a single link field
- **Tags & categories** — questions can be tagged and categorised
- **Related questions** — M:N relation between questions
- **Storage page** — questions can be stored on a dedicated folder page; falls back to the plugin's own page
- **SiteSet** — TypoScript is provided as a TYPO3 v13 SiteSet; no manual TypoScript includes required
- **Structured data toggle** — disable JSON-LD output per content element (useful when the same FAQ is embedded on
  multiple pages)

---

## Requirements

| Requirement | Version |
|-------------|---------|
| TYPO3       | 13.4+   |
| PHP         | 8.3+    |
| Bootstrap   | 5.x     |

---

## Installation

```bash
composer require oliverthiele/ot-faq
```

Then run the TYPO3 database analyser or setup command:

```bash
# via DDEV:
ddev typo3 extension:setup -e ot_faq
```

---

## Configuration

### 1. Add SiteSet

Include the SiteSet in your site configuration (`config/sites/yoursite/config.yaml`):

```yaml
dependencies:
    - oliverthiele/ot-faq
```

This automatically includes the TypoScript setup and constants — no manual `@import` needed.

### 2. Add a FAQ content element

In the TYPO3 backend, insert a **FAQ** content element (group: Extras) on the page where the FAQ should appear.

The plugin outputs one accordion per content element. Questions are managed separately in the **List** module on the
same page (or on a configured storage page).

### 3. Create questions

In the **List** module, switch to the FAQ storage page and create `tx_otfaq_domain_model_question` records. Each record
holds:

- **Question** — the question text (used as accordion header and JSON-LD `name`)
- **Answer** — rich text, restricted to Google-allowed HTML tags
- **Link** — optional fallback link shown below the answer (replaced by ot-irrebuttons buttons if that extension is
  active)
- **Related questions** — optional M:N relation
- **Tags / Categories** — optional

---

## Google FAQ Guidelines

Follow
the [Google FAQPage structured data guidelines](https://developers.google.com/search/docs/appearance/structured-data/faqpage):

- Each question must be unique across the entire site.
- Every question must be self-contained — do not reference other questions.
- Write questions exactly as a user might ask them (e.g. to a voice assistant).
- If the same FAQ content element is embedded on multiple pages, disable JSON-LD output on all but one page via the *
  *Disable structured data** checkbox in the FlexForm.

The answer field uses a restricted CKEditor preset that only allows the HTML tags Google permits in FAQ structured data:
`a`, `b`, `br`, `div`, `em`, `h2`, `h3`, `h4`, `i`, `li`, `ol`, `p`, `strong`, `ul`

---

## ot-irrebuttons Integration (optional)

When [`oliverthiele/ot-irrebuttons`](https://packagist.org/packages/oliverthiele/ot-irrebuttons) is installed:

- The **Link** field is hidden from the question form.
- An **IRRE Buttons** field is added instead — each question can have one or more buttons with individual label, link,
  icon and style.
- The controller loads the button records and sets them on the question model at runtime.
- The template renders them via the `IrreButtons` partial.

### Partial path priority

The extension uses a layered fallback for partial resolution:

| Index | Source | Content |
|-------|--------|---------|
| **0** | `EXT:ot_faq` | Minimal `IrreButtons.html` + empty `Icon.html` (last resort) |
| **15** | `EXT:ot_irrebuttons` | Full implementation with Bootstrap Icons |
| **80** | Your SitePackage | Project-specific icon system (recommended) |

No sitepackage configuration is required for basic button output. Icons will use Bootstrap Icon class names
(`bi bi-*`) by default — only relevant if Bootstrap Icons CSS is loaded in your project.

### Providing a custom icon renderer

To replace the default Bootstrap Icons with your own icon system, add an `Icon.html` partial in your sitepackage:

```typoscript
plugin.tx_otfaq {
    view {
        partialRootPaths {
            80 = EXT:your_sitepackage/Resources/Private/Extensions/OtIrrebuttons/Partials/
        }
    }
}
```

The partial receives `{iconIdentifier}` as an argument. Example using
[`oliverthiele/ot-icons`](https://packagist.org/packages/oliverthiele/ot-icons):

```html
<html xmlns:f="http://typo3.org/ns/TYPO3/CMS/Fluid/ViewHelpers"
      xmlns:i="http://typo3.org/ns/OliverThiele/OtIcons/ViewHelpers"
      data-namespace-typo3-fluid="true">
<f:section name="Main">
    <i:icon identifier="{iconIdentifier}" aria-hidden="true"/>
</f:section>
</html>
```

Or using Bootstrap Icons directly (which is the default from ot-irrebuttons):

```html
<f:section name="Main">
    <i class="bi bi-{iconIdentifier}"></i>
</f:section>
```

---

## Template Customisation

The extension follows TYPO3's template override convention. Override paths in your sitepackage TypoScript:

```typoscript
plugin.tx_otfaq {
    view {
        templateRootPaths.20 = EXT:your_sitepackage/Resources/Private/Templates/
        partialRootPaths.20  = EXT:your_sitepackage/Resources/Private/Partials/
        layoutRootPaths.20   = EXT:your_sitepackage/Resources/Private/Layouts/
    }
}
```

### Available template variables

| Variable      | Type                      | Description                                                                        |
|---------------|---------------------------|------------------------------------------------------------------------------------|
| `{questions}` | `ObjectStorage<Question>` | All question records for this content element                                      |
| `{data}`      | `array`                   | The `tt_content` record of the current content element                             |
| `{settings}`  | `array`                   | FlexForm settings (accordionFlush, initialView, alwaysOpen, disableStructuredData) |
| `{json}`      | `string`                  | Pre-encoded JSON-LD string for the FAQPage schema                                  |

### Question model properties

| Property           | Getter                  | Description                                                 |
|--------------------|-------------------------|-------------------------------------------------------------|
| `question`         | `getQuestion()`         | Question text                                               |
| `answer`           | `getAnswer()`           | HTML answer (RTE, already processed)                        |
| `link`             | `getLink()`             | Optional link (typolink format)                             |
| `irreButtons`      | `getIrreButtons()`      | Button records from ot-irrebuttons (runtime, not persisted) |
| `relatedQuestions` | `getRelatedQuestions()` | Related question records                                    |
| `tags`             | `getTags()`             | Tag records                                                 |

---

## FlexForm Options

| Option                      | Description                                                      |
|-----------------------------|------------------------------------------------------------------|
| **Storage page**            | PID of the page where question records are stored                |
| **Accordion flush**         | Remove borders and rounded corners (Bootstrap `accordion-flush`) |
| **Initial view**            | Open first question on page load, or start with all collapsed    |
| **Always open**             | Allow multiple accordion items open simultaneously               |
| **Disable structured data** | Suppress JSON-LD output for this content element                 |

---

## License

GPL-2.0-or-later — see [LICENSE](LICENSE)

## Author

Oliver Thiele — [oliver-thiele.de](https://www.oliver-thiele.de)
