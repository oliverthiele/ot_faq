<?php

use OliverThiele\OtFaq\Controller\QuestionController;
use TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider;
use TYPO3\CMS\Core\Imaging\IconRegistry;
use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') or die();

call_user_func(
    function () {
        ExtensionUtility::configurePlugin(
            'OtFaq',
            'List',
            [QuestionController::class => 'list'],
            // non-cacheable actions
            [QuestionController::class => '']
        );

        $versionInformation = GeneralUtility::makeInstance(Typo3Version::class);
        // Only include page.tsconfig if TYPO3 version is below 12 so that it is not imported twice.
        if ($versionInformation->getMajorVersion() < 12) {
            ExtensionManagementUtility::addPageTSConfig(
                '@import "EXT:ot_faq/Configuration/page.tsconfig"'
            );
        }

        $iconRegistry = GeneralUtility::makeInstance(
            IconRegistry::class
        );

        $iconRegistry->registerIcon(
            'ot_faq-plugin',
            SvgIconProvider::class,
            ['source' => 'EXT:ot_faq/Resources/Public/Icons/question.svg']
        );
    }
);
