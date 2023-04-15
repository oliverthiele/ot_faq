# FAQ-Extension

This extension for TYPO3 v11.5 allows the output of structured data for a FAQPage.

## Installation

Install the TYPO3 extension with

```shell
composer require oliverthiele/ot-faq
```

and add the TypoScript in your root Template or in your sitepackage:

### Constants:

```typo3_typoscript
@import "EXT:ot_faq/Configuration/TypoScript/constants.typoscript"
```
### Setup:

```typo3_typoscript
@import "EXT:ot_faq/Configuration/TypoScript/setup.typoscript"
```

**Don't forget to update the database structure!**


## How to add FAQs

The FAQ plugin can be added once per page. (I have deliberately decided not to use
IRRE). With the plugin only the headline is output and the position for the FAQs is defined.
In the TYPO3 BE modul "list" the questions with the answers can then be added.
Here are the rules from the Google documentation must be observed:
[https://developers.google.com/search/docs/advanced/structured-data/faqpage](
https://developers.google.com/search/docs/advanced/structured-data/faqpage)

By default, the FAQ list HTML output (Bootstrap5 based template) also generates the structured
data output in JSON format.

**New in v2.0.5:**

The storagePid (DB field pages) can now be used in the plugin. **Please make sure that no FAQ is output twice.**
If you want to output FAQs on more than one page, you should deactivate the output of structured data
via checkbox on one page.

## General notes about the FAQs

* Questions should be unique on the whole website.
* Each question should stand on its own and not refer to the other questions.
* Questions should be written exactly as they would be asked to Alexa or Siri.


## Planned improvements.

* Add an RTE configuration where only the allowed HTML tags can be used.

## Changes

### v2.0.5

* Add Support for TYPO3 v12
* Add support for storing FAQ in folders.
* Improved code quality
