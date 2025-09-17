<?php

declare(strict_types=1);

namespace OliverThiele\OtFaq\Upgrades;

use TYPO3\CMS\Install\Attribute\UpgradeWizard;
use TYPO3\CMS\Install\Updates\AbstractListTypeToCTypeUpdate;

#[UpgradeWizard('otFaqPluginListTypeToCTypeUpdate')]
final class PluginListTypeToCTypeUpdate extends AbstractListTypeToCTypeUpdate
{
    protected function getListTypeToCTypeMapping(): array
    {
        return [
            'otfaq_list' => 'otfaq_list',
        ];
    }

    public function getTitle(): string
    {
        return 'Migrates ot_faq plugins to CType';
    }

    public function getDescription(): string
    {
        return 'Migrates otfaq_list from list_type to CType. ';
    }
}
