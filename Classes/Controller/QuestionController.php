<?php

declare(strict_types=1);

/**
 * Copyright notice
 *
 * (c) 2025 Oliver Thiele <mail@oliver-thiele.de>, Web Development Oliver Thiele
 * All rights reserved
 * This script is part of the TYPO3 project. The TYPO3 project is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * This copyright notice MUST APPEAR in all copies of the script!
 */

namespace OliverThiele\OtFaq\Controller;

use Doctrine\DBAL\ArrayParameterType;
use OliverThiele\OtFaq\Domain\Model\Question;
use OliverThiele\OtFaq\Domain\Repository\QuestionRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

/***
 * This file is part of the "FAQ" Extension for TYPO3 CMS.
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *  (c) 2020-2025 Oliver Thiele <mail@oliver-thiele.de>, Web Development Oliver Thiele
 ***/

/**
 * QuestionController
 */
class QuestionController extends ActionController
{
    /**
     * Lowest valid HTML heading level (<h1>).
     */
    private const MINIMUM_HEADING_LEVEL = 1;

    /**
     * Highest valid HTML heading level (<h6>).
     */
    private const MAXIMUM_HEADING_LEVEL = 6;

    /**
     * Used when neither the content element nor TypoScript provides a usable heading level.
     */
    private const DEFAULT_HEADING_LEVEL = 2;

    public function __construct(
        protected QuestionRepository $questionRepository,
        protected ContentObjectRenderer $cObj,
        private readonly ConnectionPool $connectionPool,
    ) {
    }

    /**
     * ## List action
     *
     * Renders the FAQ list and embeds JSON-LD structured data.
     *
     * Retrieves the current tt_content record to determine optional starting pages,
     * fetches all matching Question records, and assigns them to the Fluid view.
     * In addition, it generates a valid Schema.org FAQPage JSON-LD object for
     * search engines and injects it into the rendered template.
     *
     * @return ResponseInterface HTTP response containing the rendered HTML output
     *                           with the structured data script tag.
     * @throws \JsonException    If JSON encoding of the structured data fails.
     */
    public function listAction(): ResponseInterface
    {
        $cObj = $this->request->getAttribute('currentContentObject');
        $cObjData = $cObj instanceof ContentObjectRenderer ? (get_object_vars($cObj)['data'] ?? []) : [];

        $this->view->assign('data', $cObjData);
        $this->view->assign('questionHeadingLevel', $this->resolveQuestionHeadingLevel($cObjData));

        // pages field as an integer array (automatically clears invalid entries)
        // use pages from Flexform/DB if set, otherwise fall back to the current content element pid
        $pages = GeneralUtility::intExplode(',', (string)($cObjData['pages'] ?? ''), true);

        if (empty($pages) && !empty($cObjData['pid'])) {
            $pages = [(int)$cObjData['pid']];
        }
        $questions = $this->questionRepository->findAll($pages);

        $this->view->assign('questions', $questions);

        $questionArray = [];
        /** @var Question $question */
        foreach ($questions as $question) {
            $conf = [
                'parameter' => $question->getLink(),
                'forceAbsoluteUrl' => true,
            ];
            $link = '';
            if ($conf['parameter'] !== '') {
                $label = (string)LocalizationUtility::translate('button.more.json', 'OtFaq');
                $link = '<p>' . $this->cObj->typoLink($label, $conf) . '</p>';
            }
            $questionArray[] = [
                '@type' => 'Question',
                'name' => $question->getQuestion(),
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $question->getAnswer() . $link,
                ],
            ];
        }

        $json = json_encode(
            [
                '@context' => 'https://schema.org',
                '@type' => 'FAQPage',
                'mainEntity' => $questionArray,
            ],
            JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE
        );

        $this->view->assign('json', $json);

        if (ExtensionManagementUtility::isLoaded('ot_irrebuttons')) {
            $this->enrichQuestionsWithIrreButtons($questions->toArray());
        }

        return $this->responseFactory->createResponse()
            ->withAddedHeader('Content-Type', 'text/html; charset=utf-8')
            ->withBody($this->streamFactory->createStream($this->view->render()));
    }

    /**
     * Determines the heading level used for the single questions.
     *
     * Each question sits one level below the heading of the content element itself.
     * `header_layout` may also carry values that are not heading levels at all:
     * `0` means "Default" (level comes from TypoScript) and `100` means "Hidden".
     * In both cases the configured default heading type is used instead, and the
     * result is always clamped to a valid HTML heading level (1–6).
     *
     * @param array<string, mixed> $contentElementData The tt_content record of the plugin
     */
    private function resolveQuestionHeadingLevel(array $contentElementData): int
    {
        $headingLevel = (int)($contentElementData['header_layout'] ?? 0);

        if ($headingLevel < self::MINIMUM_HEADING_LEVEL || $headingLevel > self::MAXIMUM_HEADING_LEVEL) {
            $headingLevel = (int)($this->settings['defaultHeaderType'] ?? 0);
        }

        if ($headingLevel < self::MINIMUM_HEADING_LEVEL || $headingLevel > self::MAXIMUM_HEADING_LEVEL) {
            $headingLevel = self::DEFAULT_HEADING_LEVEL;
        }

        return min($headingLevel + 1, self::MAXIMUM_HEADING_LEVEL);
    }

    /**
     * Loads IRRE button records for a set of questions and sets them directly
     * on each Question object via setIrreButtons().
     *
     * @param Question[] $questions
     */
    private function enrichQuestionsWithIrreButtons(array $questions): void
    {
        $questionUids = [];
        foreach ($questions as $question) {
            $uid = $question->getUid();
            if ($uid > 0) {
                $questionUids[] = $uid;
            }
        }

        if (empty($questionUids)) {
            return;
        }

        $queryBuilder = $this->connectionPool->getQueryBuilderForTable('tx_otirrebuttons_domain_model_button');

        $rows = $queryBuilder
            ->select('*')
            ->from('tx_otirrebuttons_domain_model_button')
            ->where(
                $queryBuilder->expr()->in(
                    'parent_id',
                    $queryBuilder->createNamedParameter($questionUids, ArrayParameterType::INTEGER)
                ),
                $queryBuilder->expr()->eq(
                    'parent_table',
                    $queryBuilder->createNamedParameter('tx_otfaq_domain_model_question')
                )
            )
            ->orderBy('parent_id', 'ASC')
            ->addOrderBy('sorting', 'ASC')
            ->executeQuery()
            ->fetchAllAssociative();

        $buttonsByQuestionUid = [];
        foreach ($rows as $row) {
            $buttonsByQuestionUid[(string)$row['parent_id']][] = ['data' => $row];
        }

        foreach ($questions as $question) {
            $question->setIrreButtons($buttonsByQuestionUid[(string)$question->getUid()] ?? []);
        }
    }

}
