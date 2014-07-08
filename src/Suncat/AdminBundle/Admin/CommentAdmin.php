<?php

namespace Suncat\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;

/**
 * Class CommentAdmin
 *
 * @author Nikolay Ivlev <nikolay.kotovsky@gmail.com>
 */
class CommentAdmin extends Admin
{
    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->add('text')
            ->add('news', 'sonata_type_model')
            ->add('createdAt')
            ->add('updatedAt');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
                ->add('text')
                ->add('news', 'sonata_type_model_list')
            ->end();
    }
}
