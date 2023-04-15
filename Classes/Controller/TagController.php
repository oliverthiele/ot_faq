<?php

declare(strict_types=1);

namespace OliverThiele\OtFaq\Controller;

use OliverThiele\OtFaq\Domain\Model\Tag;
use OliverThiele\OtFaq\Domain\Repository\TagRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

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
class TagController extends ActionController
{
    /**
     * tagRepository
     *
     * @var TagRepository
     */
    protected TagRepository $tagRepository;

    public function injectTagRepository(TagRepository $tagRepository): void
    {
        $this->tagRepository = $tagRepository;
    }

    /**
     * action list
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
     */
    public function showAction(Tag $tag): ResponseInterface
    {
        $this->view->assign('tag', $tag);

        return $this->responseFactory->createResponse()
            ->withAddedHeader('Content-Type', 'text/html; charset=utf-8')
            ->withBody($this->streamFactory->createStream($this->view->render()));
    }
}
