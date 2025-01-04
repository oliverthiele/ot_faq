<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') or die();

$pluginSignature = ExtensionUtility::registerPlugin(
    'OtFaq',
    'List',
    'FAQ',
    'icon-ot-faq',
    'extras',
    'LLL:EXT:ot_faq/Resources/Private/Language/locallang_db.xlf:tx_otfaq_list.description'
);

/**
 * Register Flexform
 */
ExtensionManagementUtility::addToAllTCAtypes(
    'tt_content',
    '--div--;Configuration,pi_flexform,',
    $pluginSignature,
    'after:subheader',
);

ExtensionManagementUtility::addPiFlexFormValue(
    '*',
    'FILE:EXT:ot_faq/Configuration/FlexForms/FlexForm.xml',
    $pluginSignature
);
