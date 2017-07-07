<?php
/**
 * Created by PhpStorm.
 * User: voronkov_vs
 * Date: 15.07.2016
 * Time: 9:32
 */

namespace ZIMkaRU\CoreBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;

class ContactAdmin extends AbstractAdmin
{
    // установка сортировки по умолчанию
    protected $datagridValues = [
        '_sort_order' => 'DESC',
        '_sort_by'    => 'createdAt'
    ];

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Контакты', ['class' =>'col-lg-6 col-xs-12'])
            ->add('name', null, ['label' => 'Имя'])
            ->add('email', null, ['label' => 'Email'])
            ->add('phone', null, ['label' => 'Телефон'])
            ->end()

            ->with('Примечания', ['class' =>'col-lg-6 col-xs-12'])
            ->add('readed', null, ['label' => 'Прочитанно'])
            ->add('notation', null, ['label' => 'Заметка'])
            ->end()
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('readed')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->addIdentifier('createdAt')
            ->addIdentifier('updatedAt')
            ->add('email')
            ->add('phone')
            ->add('readed', null, ['label' => 'Прочитанно'])
            ->add('_action', 'actions', [
                'actions' => [
                    'view' => [],
                    'edit' => [],
                    'delete' => [],
                    'readed' => array(
                        'template' => 'ZIMkaRUCoreBundle:IndexPageAdmin:list__action_readed.html.twig',
                        'label' => 'Пометить как прочитанно'
                    )
                ]
            ])
        ;
    }

    // Fields to be shown on show action
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->with('Контакты', ['class' =>'col-lg-6 col-xs-12'])
            ->add('name', null, ['label' => 'Имя'])
            ->add('createdAt', null, ['label' => 'Дата создания'])
            ->add('updatedAt', null, ['label' => 'Дата обновления'])
            ->add('email', null, ['label' => 'Email'])
            ->add('phone', null, ['label' => 'Телефон'])
            ->end()

            ->with('Примечания', ['class' =>'col-lg-6 col-xs-12'])
            ->add('readed', null, ['label' => 'Прочитанно'])
            ->add('notation', null, ['label' => 'Заметка'])
            ->end()
        ;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('readed', $this->getRouterIdParameter().'/readed');
    }
}