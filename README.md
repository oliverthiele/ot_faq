# FAQ-Extension

This TYPO3 extension outputs structured data for an FAQPage.

## Installation

Install the extension via Composer:

```shell
composer require oliverthiele/ot-faq
```

Then include the TypoScript in your root template or site-package extension:

### Constants:

```typo3_typoscript
@import "EXT:ot_faq/Configuration/TypoScript/constants.typoscript"
```
### Setup:

```typo3_typoscript
@import "EXT:ot_faq/Configuration/TypoScript/setup.typoscript"
```

**Don’t forget to update the database schema!**


## Adding FAQs

Add the FAQ plugin once per page.
(I deliberately decided not to use IRRE.)
The plugin outputs only the headline and defines the position where the FAQs appear.
In the TYPO3 List module you can then create the individual questions and answers.

Be sure to follow the [Google FAQPage guidelines](https://developers.google.com/search/docs/advanced/structured-data/faqpage)

By default, the Bootstrap-5–based template renders both the FAQ list and the structured data in JSON-LD format.


**New in v4.0.1**

- Supports TYPO3 site sets.
- PHP 8.4 compatibility.
- No more deprecated TYPO3 function calls.
- The DB field `pages` can again be used for storing FAQs.

**New in v4.0.0**

- TCA configuration optimized for TYPO3 v13.
- The extension is now registered as a **CType** instead of `list_type`.

  Use the upgrade wizard to update existing content elements.

**New in v3.0.0**

- TCA configuration optimized for TYPO3 v12.

**New in v2.0.5:**

- The storagePid (`pages` field) can now be used in the plugin.

  **Make sure no FAQ is output twice.**

  If you need to display FAQs on multiple pages, disable structured-data output
  via the checkbox on one of those pages.


## General Notes

- Each question should be unique across the entire site.
- Every question must stand on its own and not refer to others.
- Write questions exactly as a user might ask them (e.g. to Alexa or Siri).


* Questions should be unique on the whole website.
* Each question should stand on its own and not refer to the other questions.
* Questions should be written exactly as they would be asked to Alexa or Siri.


## Planned Improvements

- Add an RTE configuration that allows only a restricted set of HTML tags.

## Changes

### v3.0.0

- Dropped support for TYPO3 v11.

### v2.0.5

- Added TYPO3 v12 support.
- Added support for storing FAQs in folders.
- Improved code quality.
