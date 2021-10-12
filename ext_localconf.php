<?php

defined('TYPO3') or die();

call_user_func(
    function () {
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'OtFaq',
            'List',
            [\OliverThiele\OtFaq\Controller\QuestionController::class => 'list'],
            // non-cacheable actions
            [\OliverThiele\OtFaq\Controller\QuestionController::class => ''],
            \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_PLUGIN
        );

        // wizards
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
            'mod {
            wizards.newContentElement.wizardItems.plugins {
                elements {
                    list {
                        iconIdentifier = ot_faq-plugin
                        title = LLL:EXT:ot_faq/Resources/Private/Language/locallang_db.xlf:tx_ot_faq_list.name
                        description = LLL:EXT:ot_faq/Resources/Private/Language/locallang_db.xlf:tx_ot_faq_list.description
                        tt_content_defValues {
                            CType = list
                            list_type = otfaq_list
                        }
                    }
                }
                show = *
            }
       }'
        );

        $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
            \TYPO3\CMS\Core\Imaging\IconRegistry::class
        );

        $iconRegistry->registerIcon(
            'ot_faq-plugin',
            \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
            ['source' => 'EXT:ot_faq/Resources/Public/Icons/question.svg']
        );

        // Feature is not ready yet
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
            '
                TCEFORM.tx_otfaq_domain_model_question.tags.disabled = 1
                TCEFORM.tx_otfaq_domain_model_question.related_questions.disabled = 1
        '
        );
    }
);
