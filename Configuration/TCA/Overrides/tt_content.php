<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') or die();

ExtensionUtility::registerPlugin(
    'OtFaq',
    'List',
    'FAQ',
    'EXT:ot_faq/Resources/Public/Icons/Extension.svg'
);

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['otfaq_list'] = 'recursive';

/**
 * Register Flexform
 */
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['otfaq_list'] = 'pi_flexform';

ExtensionManagementUtility::addPiFlexFormValue(
    'otfaq_list',
    'FILE:EXT:ot_faq/Configuration/FlexForms/FlexForm.xml'
);
