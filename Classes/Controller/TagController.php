<?php

declare(strict_types=1);

namespace OliverThiele\OtFaq\Controller;


use OliverThiele\OtFaq\Domain\Repository\TagRepository;
use Psr\Http\Message\ResponseInterface;

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
 * TagController
 */
class TagController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * tagRepository
     *
     * @var TagRepository|null
     */
    protected ?TagRepository $tagRepository = null;

    /**
     * @param  TagRepository  $tagRepository
     */
    public function injectTagRepository(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    /**
     * action list
     *
     * @return ResponseInterface
     */
    public function listAction(): ResponseInterface
    {
        $tags = $this->tagRepository->findAll();
        $this->view->assign('tags', $tags);

        return $this->responseFactory->createResponse()
            ->withAddedHeader('Content-Type', 'text/html; charset=utf-8')
            ->withBody($this->streamFactory->createStream($this->view->render()));
    }

    /**
     * action show
     *
     * @param  \OliverThiele\OtFaq\Domain\Model\Tag  $tag
     * @return  ResponseInterface
     */
    public function showAction(\OliverThiele\OtFaq\Domain\Model\Tag $tag): ResponseInterface
    {
        $this->view->assign('tag', $tag);

        return $this->responseFactory->createResponse()
            ->withAddedHeader('Content-Type', 'text/html; charset=utf-8')
            ->withBody($this->streamFactory->createStream($this->view->render()));
    }
}
