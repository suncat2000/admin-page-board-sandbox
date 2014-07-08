<?php

namespace Suncat\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;

/**
 * Class NewsAdmin
 *
 * @author Nikolay Ivlev <nikolay.kotovsky@gmail.com>
 */
class NewsAdmin extends Admin
{
    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->add('enabled')
            ->add('title')
            ->add('text')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'news_board' => array('template' => 'SuncatAdminBundle:CRUD:list__action_news_board.html.twig'),
                )
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $filterMapper)
    {
        $filterMapper
            ->add('enabled');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
                ->add('enabled')
                ->add('title')
                ->add('text')
                ->add('tags', 'sonata_type_model', ['multiple' => true, 'expanded' => true])
            ->end();
    }
}
