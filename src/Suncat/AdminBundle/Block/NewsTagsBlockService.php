<?php

namespace Suncat\AdminBundle\Block;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Validator\ErrorElement;

use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Block\BaseBlockService;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

/**
 * Class NewsTagsBlockService
 *
 * @author Nikolay Ivlev <nikolay.kotovsky@gmail.com>
 */
class NewsTagsBlockService extends BaseBlockService
{
    protected $entityManager;

    /**
     * @param string $name
     * @param EngineInterface $templating
     * @param EntityManager $entityManager
     */
    public function __construct($name, EngineInterface $templating, EntityManager $entityManager)
    {
        parent::__construct($name, $templating);

        $this->entityManager = $entityManager;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'News comments';
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'template' => 'SuncatAdminBundle:Block:block_news_tags.html.twig',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildEditForm(FormMapper $formMapper, BlockInterface $block)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function validateBlock(ErrorElement $errorElement, BlockInterface $block)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        // merge settings
        $settings = $blockContext->getSettings();

        if (null === $settings['route_params']) {
            throw new \RuntimeException('Route params is null');
        }
        if (!isset($settings['route_params']['id'])) {
            throw new \RuntimeException('News id route param is not exist');
        }

        $newsId = (int) $settings['route_params']['id'];

        $news = $this->entityManager->getRepository('SuncatAdminBundle:News')->findOneBy(['id' => $newsId]);

        if (null === $news) {
            throw new \RuntimeException('News not found');
        }

        $tags = $news->getTags();

        return $this->renderResponse($blockContext->getTemplate(), array(
            'news'     => $news,
            'tags'     => $tags,
            'block'     => $blockContext->getBlock(),
            'settings'  => $settings
        ), $response);
    }
}
