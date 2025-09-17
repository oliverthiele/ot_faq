<?php

declare(strict_types=1);

namespace OliverThiele\OtFaq\Controller;

use OliverThiele\OtFaq\Domain\Model\Question;
use OliverThiele\OtFaq\Domain\Repository\QuestionRepository;
use Psr\Http\Message\ResponseInterface;
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
    public function __construct(protected QuestionRepository $questionRepository, protected ContentObjectRenderer $cObj) {}

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
        $cObjData = $cObj?->data ?? [];

        $this->view->assign('data', $cObjData);

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

        return $this->responseFactory->createResponse()
            ->withAddedHeader('Content-Type', 'text/html; charset=utf-8')
            ->withBody($this->streamFactory->createStream($this->view->render()));
    }
}
