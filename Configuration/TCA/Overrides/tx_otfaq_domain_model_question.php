<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') or die();

// When ot_irrebuttons is installed, buttons are managed per question via IRRE.
// The per-question link field is removed to avoid confusion.
if (ExtensionManagementUtility::isLoaded('ot_irrebuttons')) {
    $ll_irre = 'LLL:EXT:ot_irrebuttons/Resources/Private/Language/locallang_be.xlf:';

    $GLOBALS['TCA']['tx_otfaq_domain_model_question']['columns']['tx_otirrebuttons_domain_model_buttons'] = [
        'exclude' => true,
        'label' => $ll_irre . 'tx_otirrebuttons_domain_model_button.label',
        'description' => $ll_irre . 'tx_otirrebuttons_domain_model_button.description',
        'config' => [
            'type' => 'inline',
            'foreign_field' => 'parent_id',
            'foreign_table' => 'tx_otirrebuttons_domain_model_button',
            'foreign_sortby' => 'sorting',
            'foreign_table_field' => 'parent_table',
            'appearance' => [
                'collapseAll' => true,
                'showSynchronizationLink' => true,
                'showAllLocalizationLink' => true,
                'useSortable' => true,
                'showPossibleLocalizationRecords' => true,
            ],
        ],
    ];

    $GLOBALS['TCA']['tx_otfaq_domain_model_question']['types']['1']['showitem']
        = 'sys_language_uid, l10n_parent, l10n_diffsource,
         question, answer, tx_otirrebuttons_domain_model_buttons, related_questions,
         --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
            --palette--;;hidden,
            --palette--;;access,
         --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:categories, categories';
}
