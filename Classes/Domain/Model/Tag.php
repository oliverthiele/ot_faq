<?php

declare(strict_types=1);

namespace OliverThiele\OtFaq\Domain\Model;

use TYPO3\CMS\Extbase\Annotation as Extbase;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/***
 *
 * This file is part of the "FAQ" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2020-2021 Oliver Thiele <mail@oliver-thiele.de>, Web Development Oliver Thiele
 *
 ***/

/**
 * Tag
 */
class Tag extends AbstractEntity
{
    /**
     * Tag
     *
     * @var string
     * @Extbase\Annotation\Validate("NotEmpty")
     */
    protected $tag = '';

    /**
     * Returns the tag
     *
     * @return string $tag
     */
    public function getTag(): string
    {
        return $this->tag;
    }

    /**
     * Sets the tag
     *
     * @param  string  $tag
     */
    public function setTag($tag): void
    {
        $this->tag = $tag;
    }
}
