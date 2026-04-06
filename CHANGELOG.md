# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

---

## [5.0.1] — 2026-04-06

### Added

- `IrreButtons.html` and `Icon.html` fallback partials shipped with ot_faq at partial index 0 — ensures buttons are
  rendered even without any sitepackage configuration
- Empty `Icon.html` in ot_faq overrides the Bootstrap Icons default (index 15, from ot_irrebuttons) so no
  unstyled icon markup is output in projects that do not load Bootstrap Icons CSS
- Full `IrreButtons.html` at index 0 as last-resort fallback in case ot_irrebuttons partials are unavailable

### Changed

- README: ot-irrebuttons integration section updated to document the three-level partial fallback hierarchy
  (index 0 ot_faq → index 15 ot_irrebuttons → index 80 sitepackage)

---

## [5.0.0] — 2026-04-06

### Added

- **ot-irrebuttons integration** — when `oliverthiele/ot-irrebuttons` is installed, each question gains an IRRE buttons
  field; the `link` field is hidden automatically via TCA Override
- `Question::$irreButtons` transient property — button records are loaded at runtime by the controller and set directly
  on the domain model object; no persistence
- `QuestionController::enrichQuestionsWithIrreButtons()` — loads all button records for the current question set in a
  single query, filtered by `parent_table = tx_otfaq_domain_model_question`
- `QuestionController::addIrreButtonsPartialPath()` — adds `EXT:ot_irrebuttons/.../Partials/` to the Extbase view at
  runtime (index 15), consistent with `lib.contentElement` convention; no TypoScript condition required
- **Restricted RTE preset** `otFaqAnswer` — CKEditor 5 toolbar and `processing.allowTags` limited to HTML tags permitted
  by Google's FAQ structured data specification (`a`, `b`, `br`, `div`, `em`, `h2`–`h4`, `i`, `li`, `ol`, `p`, `strong`,
  `ul`)
- **Custom parseFunc** `lib.parseFuncOtFaqAnswer` — additional frontend-side tag stripping based on `lib.parseFunc_RTE`
- Soft-hyphen button (`softhyphen`) added to the FAQ answer RTE toolbar

### Changed

- `answer` field now uses `'richtextConfiguration' => 'otFaqAnswer'` instead of `'default'`
- Template: `f:format.html()` now passes `parseFuncTSPath: 'lib.parseFuncOtFaqAnswer'`
- Template: ot-irrebuttons buttons are rendered per question via `{question.irreButtons}`; fallback to `{question.link}`
  when no buttons are configured

---

## [4.1.1] — 2025-xx-xx

### Added

- SiteKit configuration (`Configuration/SiteKit.yaml`)
- Templates moved to new directory structure

### Fixed

- Code quality improvements

---

## [4.0.1] — 2025-09-17

### Added

- TYPO3 Site Sets support
- PHP 8.4 compatibility

### Fixed

- Removed deprecated TYPO3 function calls
- Restored `pages` field handling for storage page configuration

---

## [4.0.0] — 2025-01-04

### Changed

- TCA configuration optimised for TYPO3 v13
- Extension is now registered as a **CType** instead of `list_type`

### Added

- Upgrade wizard to migrate existing `list_type` content elements to CType

---

## [3.0.1] — 2024-12-03

### Fixed

- Maintenance release

---

## [3.0.0] — 2024-05-16

### Changed

- TCA configuration optimised for TYPO3 v12
- Dropped support for TYPO3 v11

---

## [2.0.5] — 2023-06-28

### Added

- `pages` field support — FAQs can now be stored on a dedicated folder page
- TYPO3 v12 support

### Fixed

- Improved code quality

---

## [2.0.4] — 2022-04-19

### Fixed

- Minor fixes

---

## [1.0.0] — 2020-12-28

### Added

- Initial public release for TYPO3 v11.5
