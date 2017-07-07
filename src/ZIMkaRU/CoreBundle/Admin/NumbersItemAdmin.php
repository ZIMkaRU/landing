<?php
/**
 * Created by PhpStorm.
 * User: voronkov_vs
 * Date: 15.07.2016
 * Time: 9:32
 */

namespace ZIMkaRU\CoreBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class NumbersItemAdmin extends AbstractAdmin
{
    protected $datagridValues = [
        '_sort_order' => 'ASC',
        '_sort_by'    => 'createdAt'
    ];

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Контент', ['class' =>'col-lg-6 col-xs-12'])
            ->add('name', null, ['label' => 'Имя блока',])
            ->add('number', null, ['label' => 'Значение числа',])
            ->add('postNumbText', null, ['label' => 'Текст после числа',])
            ->add('body', null, ['label' => 'Основной текст',])
            ->end()
        ;

        if(!$this->hasParentFieldDescription()) {
            $formMapper
                ->with('Где содержится', ['class' =>'col-lg-6 col-xs-12'])
                ->add('indexPage', 'sonata_type_model_list', array(
                    'sonata_admin' => 'sonata.admin.index_page',
                    'by_reference' => true,
                    'label' => 'Имя шаблона',
                    'btn_add' => false,
                    'btn_delete' => false,
                ), array(
                    'placeholder' => 'Шаблон не выбран'
                ))
                ->end()
            ;
        }
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('number')
            ->add('createdAt')
            ->add('updatedAt')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->addIdentifier('number')
            ->addIdentifier('postNumbText')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('_action', 'actions', [
                'actions' => [
                    'view' => [],
                    'edit' => [],
                    'delete' => [],
                    'clone' => array(
                        'template' => 'ZIMkaRUCoreBundle:IndexPageAdmin:list__action_clone.html.twig'
                    )
                ]
            ])
        ;
    }

    // Fields to be shown on show action
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->with('Контент', ['class' =>'col-lg-6 col-xs-12'])
            ->add('name', null, ['label' => 'Имя блока',])
            ->add('createdAt', null, ['label' => 'Дата создания'])
            ->add('updatedAt', null, ['label' => 'Дата обновления'])
            ->add('number', null, ['label' => 'Значение числа',])
            ->add('postNumbText', null, ['label' => 'Текст после числа',])
            ->add('body', null, ['label' => 'Основной текст',])
            ->end()
            ->with('Где содержится', ['class' =>'col-lg-6 col-xs-12'])
            ->add('indexPage', 'sonata_type_model_list', ['label' => 'Имя шаблона'])
            ->end()
        ;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('clone', $this->getRouterIdParameter().'/clone');
    }
}