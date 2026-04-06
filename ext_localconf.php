<?php

use OliverThiele\OtFaq\Controller\QuestionController;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') or die();

$GLOBALS['TYPO3_CONF_VARS']['RTE']['Presets']['otFaqAnswer'] = 'EXT:ot_faq/Configuration/RTE/OtFaqAnswer.yaml';

call_user_func(
    static function () {
        ExtensionUtility::configurePlugin(
            'OtFaq',
            'List',
            [QuestionController::class => 'list'],
            // non-cacheable actions
            [],
            ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT,
        );
    }
);
