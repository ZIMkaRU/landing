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

class PortfolioItemAdmin extends AbstractAdmin
{
    protected $datagridValues = [
        '_sort_order' => 'ASC',
        '_sort_by'    => 'createdAt'
    ];

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        if($this->hasParentFieldDescription()) {
            $parent = $this->getParentFieldDescription()->getAdmin()->getSubject()->getPropositionItems()[0];
            if($parent) {
                $subject = $parent;
            } else {
                $subject = new \ZIMkaRU\CoreBundle\Entity\PortfolioItem;
            }
        } else {
            $subject = $this->getSubject();
        }

        if(!$this->hasParentFieldDescription()) {
            $formMapper
                ->with('Где содержится', ['class' =>'col-xs-12'])
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

        $formMapper
            ->with('Контент', ['class' =>'col-lg-6 col-xs-12'])
            ->add('name', null, ['label' => 'Имя блока',])
            ->add('header', null, ['label' => 'Заглавие',])
            ->add('body', null, ['label' => 'Основной текст',])
            ->add('label', null, ['label' => 'Метка изображения',])
            ->end()
            ->with('Изображения', ['class' =>'col-lg-6 col-xs-12'])
            ->add('portfolioImage', 'comur_image', array(
                'uploadConfig' => array(
                    'uploadRoute' => 'comur_api_upload',        //optional
                    'uploadUrl' => $subject->getUploadRootDir(),       // required - see explanation below (you can also put just a dir path)
                    'webDir' => $subject->getUploadDir(),              // required - see explanation below (you can also put just a dir path)
                    'fileExt' => '*.jpg;*.gif;*.png;*.jpeg',    //optional
                    'libraryDir' => null,                       //optional
                    'libraryRoute' => 'comur_api_image_library', //optional
                    'showLibrary' => true,                      //optional
                    'saveOriginal' => 'portfolioImageOriginal',          //optional
                    'generateFilename' => true          //optional
                ),
                'cropConfig' => array(
                    'minWidth' => 480,
                    'minHeight' => 354,
                    'aspectRatio' => true,              //optional
                    'cropRoute' => 'comur_api_crop',    //optional
                    'forceResize' => true,             //optional
                    'thumbs' => array(                  //optional
                        array(
                            'maxWidth' => 300,
                            'maxHeight' => 500,
                            'useAsFieldImage' => true  //optional
                        )
                    )
                ),
                'required' => false, 'label' => $this->hasParentFieldDescription()
            ))
            ->end()
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('header')
            ->add('createdAt')
            ->add('updatedAt')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('portfolioImage', 'string', array('template' => 'ZIMkaRUCoreBundle:IndexPageAdmin:list_field_image_thumb.html.twig'))
            ->addIdentifier('name')
            ->addIdentifier('header')
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
            ->with('Где содержится', ['class' =>'col-xs-12'])
            ->add('indexPage', 'sonata_type_model_list', ['label' => 'Имя шаблона'])
            ->end()
            ->with('Контент', ['class' =>'col-lg-6 col-xs-12'])
            ->add('name', null, ['label' => 'Имя блока',])
            ->add('createdAt', null, ['label' => 'Дата создания'])
            ->add('updatedAt', null, ['label' => 'Дата обновления'])
            ->add('header', null, ['label' => 'Заглавие',])
            ->add('body', null, ['label' => 'Основной текст',])
            ->add('label', null, ['label' => 'Метка изображения',])
            ->end()
            ->with('Изображения', ['class' =>'col-lg-6 col-xs-12'])
            ->add('portfolioImage', 'string', array('template' => 'ZIMkaRUCoreBundle:IndexPageAdmin:show_field_image_thumb.html.twig'))
            ->end()
        ;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('clone', $this->getRouterIdParameter().'/clone');
    }
}