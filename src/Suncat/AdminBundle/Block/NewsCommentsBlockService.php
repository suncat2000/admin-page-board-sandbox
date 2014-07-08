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
 * Class NewsCommentsBlockService
 *
 * @author Nikolay Ivlev <nikolay.kotovsky@gmail.com>
 */
class NewsCommentsBlockService extends BaseBlockService
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
            'template' => 'SuncatAdminBundle:Block:block_news_comments.html.twig',
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

        $comments = $this->entityManager->getRepository('SuncatAdminBundle:Comment')->findBy(['news' => $newsId]);

        return $this->renderResponse($blockContext->getTemplate(), array(
            'comments'     => $comments,
            'block'     => $blockContext->getBlock(),
            'settings'  => $settings
        ), $response);
    }
}
