<?php

defined('TYPO3') or die();

call_user_func(
    function () {
        TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages(
            'tx_otfaq_domain_model_question'
        );

        TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr(
            'tx_otfaq_domain_model_question',
            'EXT:ot_faq/Resources/Private/Language/locallang_csh_tx_otfaq_domain_model_question.xlf'
        );

        TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr(
            'tx_otfaq_domain_model_tag',
            'EXT:ot_faq/Resources/Private/Language/locallang_csh_tx_otfaq_domain_model_tag.xlf'
        );
    }
);
