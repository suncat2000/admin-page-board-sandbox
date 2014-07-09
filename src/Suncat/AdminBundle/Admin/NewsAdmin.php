<?php

namespace Suncat\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;

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
                    'board' => array('route' => 'admin_suncat_admin_news_board'),
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

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->with('General')
                ->add('enabled')
                ->add('title')
                ->add('text')
            ->end()
            ->with('Timestampable')
                ->add('createdAt')
                ->add('updatedAt')
            ->end()
        ;
    }
}
