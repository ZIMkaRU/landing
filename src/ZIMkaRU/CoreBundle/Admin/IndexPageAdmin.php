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

class IndexPageAdmin extends AbstractAdmin
{
    // установка сортировки по умолчанию
    protected $datagridValues = [
        '_sort_order' => 'ASC',
        '_sort_by'    => 'createdAt'
    ];

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        if($this->hasParentFieldDescription()) {
            $getter = 'get' . $this->getParentFieldDescription()->getFieldName();
            $parent = $this->getParentFieldDescription()->getAdmin()->getSubject();
            if($parent) {
                $subject = $parent->$getter();
            } else {
                $subject = null;
            }
        } else {
            $subject = $this->getSubject();
        }


        $formMapper
            ->tab('Основное')
            ->with('Контент', ['class' =>'col-lg-6 col-xs-12'])
            ->add('name', null, ['label' => 'Имя шаблона'])
            ->add('footerLabel', null, ['label' => 'Метка футера'])
            ->end()
            ->with('Логотип', ['class' =>'col-lg-6 col-xs-12'])
            ->add('logoImage', 'comur_image', array(
                'uploadConfig' => array(
                    'uploadRoute' => 'comur_api_upload',        //optional
                    'uploadUrl' => $subject->getUploadRootDir(),       // required - see explanation below (you can also put just a dir path)
                    'webDir' => $subject->getUploadDir(),              // required - see explanation below (you can also put just a dir path)
                    'fileExt' => '*.jpg;*.gif;*.png;*.jpeg',    //optional
                    'libraryDir' => null,                       //optional
                    'libraryRoute' => 'comur_api_image_library', //optional
                    'showLibrary' => true,                      //optional
                    'saveOriginal' => 'logoImageOriginal',          //optional
                    'generateFilename' => true          //optional
                ),
                'cropConfig' => array(
                    'minWidth' => 328,
                    'minHeight' => 100,
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
            ->end()


            ->tab('Форма обр. связи')
            ->with('Контент', ['class' =>'col-lg-6 col-xs-12'])
            ->add('feedbackHeader', null, ['label' => 'Заглавие',])
            ->add('feedbackBody', null, ['label' => 'Основной текст',])
            ->add('feedbackLabelName', null, ['label' => 'Поле Имя',])
            ->add('feedbackLabelEmail', null, ['label' => 'Поле Email',])
            ->add('feedbackLabelPhone', null, ['label' => 'Поле Телефон',])
            ->add('feedbackLabelBtnSub', null, ['label' => 'Кнопка отправить',])
            ->end()
            ->with('Фон', ['class' =>'col-lg-6 col-xs-12'])
            ->add('feedbackImage', 'comur_image', array(
                'uploadConfig' => array(
                    'uploadRoute' => 'comur_api_upload',        //optional
                    'uploadUrl' => $subject->getUploadRootDir(),       // required - see explanation below (you can also put just a dir path)
                    'webDir' => $subject->getUploadDir(),              // required - see explanation below (you can also put just a dir path)
                    'fileExt' => '*.jpg;*.gif;*.png;*.jpeg',    //optional
                    'libraryDir' => null,                       //optional
                    'libraryRoute' => 'comur_api_image_library', //optional
                    'showLibrary' => true,                      //optional
                    'saveOriginal' => 'feedbackImageOriginal',          //optional
                    'generateFilename' => true          //optional
                ),
                'cropConfig' => array(
                    'minWidth' => 1920,
                    'minHeight' => 680,
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
            ->end()


            ->tab('Предложения')
            ->with('Контент', ['class' =>'col-lg-6 col-xs-12'])
            ->add('propositionHeader', null, ['label' => 'Заглавие',])
            ->add('propositionBody', null, ['label' => 'Основной текст',])
            ->end()
            ->with('Блоки', ['class' =>'col-lg-6 col-xs-12'])
            ->add('propositionItems', 'sonata_type_collection', array(
                'cascade_validation' => true,
                'by_reference' => false,
                'required' => true,
                'label' => 'Блоки',
                'type_options' => array(
                    // Prevents the "Delete" option from being displayed
                    'delete' => true
                )
            ), array(
                'edit' => 'inline',
                'sortable' => 'position',
                'limit' => 3
            ))
            ->end()
            ->end()


            ->tab('Особенности')
            ->with('Контент', ['class' =>'col-lg-6 col-xs-12'])
            ->add('featuresHeader', null, ['label' => 'Заглавие',])
            ->add('featuresLabelBtnSub', null, ['label' => 'Кнопка отправить',])
            ->add('featuresImage', 'comur_image', array(
                'uploadConfig' => array(
                    'uploadRoute' => 'comur_api_upload',        //optional
                    'uploadUrl' => $subject->getUploadRootDir(),       // required - see explanation below (you can also put just a dir path)
                    'webDir' => $subject->getUploadDir(),              // required - see explanation below (you can also put just a dir path)
                    'fileExt' => '*.jpg;*.gif;*.png;*.jpeg',    //optional
                    'libraryDir' => null,                       //optional
                    'libraryRoute' => 'comur_api_image_library', //optional
                    'showLibrary' => true,                      //optional
                    'saveOriginal' => 'featuresImageOriginal',          //optional
                    'generateFilename' => true          //optional
                ),
                'cropConfig' => array(
                    'minWidth' => 1920,
                    'minHeight' => 587,
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
            ->with('Блоки', ['class' =>'col-lg-6 col-xs-12'])
            ->add('featuresItems', 'sonata_type_collection', array(
                'cascade_validation' => true,
                'by_reference' => false,
                'required' => true,
                'label' => 'Блоки',
                'type_options' => array(
                    // Prevents the "Delete" option from being displayed
                    'delete' => true
                )
            ), array(
                'edit' => 'inline',
                'sortable' => 'position',
                'limit' => 4
            ))
            ->end()
            ->end()


            ->tab('Портфолио')
            ->with('Контент', ['class' =>'col-lg-6 col-xs-12'])
            ->add('portfolioHeader', null, ['label' => 'Заглавие',])
            ->add('portfolioBody', null, ['label' => 'Основной текст',])
            ->end()
            ->with('Блоки', ['class' =>'col-lg-6 col-xs-12'])
            ->add('portfolioItems', 'sonata_type_collection', array(
                'cascade_validation' => true,
                'by_reference' => false,
                'required' => true,
                'label' => 'Блоки',
                'type_options' => array(
                    // Prevents the "Delete" option from being displayed
                    'delete' => true
                )
            ), array(
                'edit' => 'inline',
                'sortable' => 'position',
                'limit' => 8
            ))
            ->end()
            ->end()


            ->tab('Мы в цифрах')
            ->with('Контент', ['class' =>'col-lg-6 col-xs-12'])
            ->add('numbersHeader', null, ['label' => 'Заглавие',])
            ->end()
            ->with('Блоки', ['class' =>'col-lg-6 col-xs-12'])
            ->add('numbersItems', 'sonata_type_collection', array(
                'cascade_validation' => true,
                'by_reference' => false,
                'required' => true,
                'label' => 'Блоки',
                'type_options' => array(
                    // Prevents the "Delete" option from being displayed
                    'delete' => true
                )
            ), array(
                'edit' => 'inline',
                'sortable' => 'position',
                'limit' => 6
            ))
            ->end()
            ->end()


            ->tab('Галерея')
            ->with('Контент', ['class' =>'col-lg-6 col-xs-12'])
            ->add('galleryHeader', null, ['label' => 'Заглавие',])
            ->add('galleryLabel', null, ['label' => 'Текстовая метка',])
            ->end()
            ->with('Изображения', ['class' =>'col-lg-6 col-xs-12'])
            ->add('gallery', 'comur_gallery', array(
                'uploadConfig' => array(
                    'uploadRoute' => 'comur_api_upload',        //optional
                    'uploadUrl' => $subject->getUploadRootDir(),       // required - see explanation below (you can also put just a dir path)
                    'webDir' => $subject->getUploadDir(),              // required - see explanation below (you can also put just a dir path)
                    'fileExt' => '*.jpg;*.gif;*.png;*.jpeg',    //optional
                    'libraryDir' => null,                       //optional
                    'libraryRoute' => 'comur_api_image_library', //optional
                    'showLibrary' => true,                      //optional
                    'saveOriginal' => '',          //optional
                    'generateFilename' => true          //optional
                ),
                'cropConfig' => array(
                    'minWidth' => 1250,
                    'minHeight' => 834,
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
            ->end()


            ->tab('Контакты')
            ->with('Контент', ['class' =>'col-lg-6 col-xs-12 col-lg-offset-3'])
            ->add('contactsHeader', null, ['label' => 'Заглавие',])
            ->add('contactsPhone', null, ['label' => 'Телефон',])
            ->add('contactsEmail', null, ['label' => 'Email',])
            ->end()
            ->with('Изображение телефона', ['class' =>'col-lg-6 col-xs-12'])
            ->add('contactsPhoneImage', 'comur_image', array(
                'uploadConfig' => array(
                    'uploadRoute' => 'comur_api_upload',        //optional
                    'uploadUrl' => $subject->getUploadRootDir(),       // required - see explanation below (you can also put just a dir path)
                    'webDir' => $subject->getUploadDir(),              // required - see explanation below (you can also put just a dir path)
                    'fileExt' => '*.jpg;*.gif;*.png;*.jpeg',    //optional
                    'libraryDir' => null,                       //optional
                    'libraryRoute' => 'comur_api_image_library', //optional
                    'showLibrary' => true,                      //optional
                    'saveOriginal' => 'contactsPhoneImageOriginal',          //optional
                    'generateFilename' => true          //optional
                ),
                'cropConfig' => array(
                    'minWidth' => 45,
                    'minHeight' => 45,
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
            ->with('Изображение Email', ['class' =>'col-lg-6 col-xs-12'])
            ->add('contactsEmailImage', 'comur_image', array(
                'uploadConfig' => array(
                    'uploadRoute' => 'comur_api_upload',        //optional
                    'uploadUrl' => $subject->getUploadRootDir(),       // required - see explanation below (you can also put just a dir path)
                    'webDir' => $subject->getUploadDir(),              // required - see explanation below (you can also put just a dir path)
                    'fileExt' => '*.jpg;*.gif;*.png;*.jpeg',    //optional
                    'libraryDir' => null,                       //optional
                    'libraryRoute' => 'comur_api_image_library', //optional
                    'showLibrary' => true,                      //optional
                    'saveOriginal' => 'contactsEmailImageOriginal',          //optional
                    'generateFilename' => true          //optional
                ),
                'cropConfig' => array(
                    'minWidth' => 45,
                    'minHeight' => 45,
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
            ->end()


            ->tab('SEO')
            ->with('Контент', ['class' =>'col-lg-6 col-xs-12 col-lg-offset-3'])
            ->add('title')
            ->add('keywords')
            ->add('description')
            ->end()
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
            ->add('active')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('logoImage', 'string', array('template' => 'ZIMkaRUCoreBundle:IndexPageAdmin:list_field_image_thumb.html.twig'))
            ->addIdentifier('name')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('active')
            ->add('_action', 'actions', [
                'actions' => [
                    'view' => [],
                    'edit' => [],
                    'delete' => [],
                    'clone' => array(
                        'template' => 'ZIMkaRUCoreBundle:IndexPageAdmin:list__action_clone.html.twig'
                    ),
                    'active' => array(
                        'template' => 'ZIMkaRUCoreBundle:IndexPageAdmin:list__action_active.html.twig'
                    )
                ]
            ])
        ;
    }

    // Fields to be shown on show action
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->tab('Основное')
            ->with('Контент', ['class' =>'col-lg-6 col-xs-12'])
            ->add('name', null, ['label' => 'Имя шаблона'])
            ->add('createdAt', null, ['label' => 'Дата создания'])
            ->add('updatedAt', null, ['label' => 'Дата обновления'])
            ->add('active', null, ['label' => 'Активность шаблона'])
            ->add('footerLabel', null, ['label' => 'Метка футера'])
            ->end()
            ->with('Логотип', ['class' =>'col-lg-6 col-xs-12'])
            ->add('logoImage', 'string', array('template' => 'ZIMkaRUCoreBundle:IndexPageAdmin:show_field_image_thumb.html.twig'))
            ->end()
            ->end()


            ->tab('Форма обр. связи')
            ->with('Контент', ['class' =>'col-lg-6 col-xs-12'])
            ->add('feedbackHeader', null, ['label' => 'Заглавие',])
            ->add('feedbackBody', null, ['label' => 'Основной текст',])
            ->add('feedbackLabelName', null, ['label' => 'Поле Имя',])
            ->add('feedbackLabelEmail', null, ['label' => 'Поле Email',])
            ->add('feedbackLabelPhone', null, ['label' => 'Поле Телефон',])
            ->add('feedbackLabelBtnSub', null, ['label' => 'Кнопка отправить',])
            ->end()
            ->with('Фон', ['class' =>'col-lg-6 col-xs-12'])
            ->add('feedbackImage', 'string', array('template' => 'ZIMkaRUCoreBundle:IndexPageAdmin:show_field_image_thumb.html.twig'))
            ->end()
            ->end()


            ->tab('Предложения')
            ->with('Контент', ['class' =>'col-lg-6 col-xs-12'])
            ->add('propositionHeader', null, ['label' => 'Заглавие',])
            ->add('propositionBody', null, ['label' => 'Основной текст',])
            ->end()
            ->with('Блоки', ['class' =>'col-lg-6 col-xs-12'])
            ->add('propositionItems', 'sonata_type_collection')
            ->end()
            ->end()


            ->tab('Особенности')
            ->with('Контент', ['class' =>'col-lg-6 col-xs-12'])
            ->add('featuresHeader', null, ['label' => 'Заглавие',])
            ->add('featuresLabelBtnSub', null, ['label' => 'Кнопка отправить',])
            ->add('featuresImage', 'string', array('template' => 'ZIMkaRUCoreBundle:IndexPageAdmin:show_field_image_thumb.html.twig'))
            ->end()
            ->with('Блоки', ['class' =>'col-lg-6 col-xs-12'])
            ->add('featuresItems', 'sonata_type_collection')
            ->end()
            ->end()


            ->tab('Портфолио')
            ->with('Контент', ['class' =>'col-lg-6 col-xs-12'])
            ->add('portfolioHeader', null, ['label' => 'Заглавие',])
            ->add('portfolioBody', null, ['label' => 'Основной текст',])
            ->end()
            ->with('Блоки', ['class' =>'col-lg-6 col-xs-12'])
            ->add('portfolioItems', 'sonata_type_collection')
            ->end()
            ->end()


            ->tab('Мы в цифрах')
            ->with('Контент', ['class' =>'col-lg-6 col-xs-12'])
            ->add('numbersHeader', null, ['label' => 'Заглавие',])
            ->end()
            ->with('Блоки', ['class' =>'col-lg-6 col-xs-12'])
            ->add('numbersItems', 'sonata_type_collection')
            ->end()
            ->end()


            ->tab('Галерея')
            ->with('Контент', ['class' =>'col-lg-6 col-xs-12 col-lg-offset-3'])
            ->add('galleryHeader', null, ['label' => 'Заглавие',])
            ->add('galleryLabel', null, ['label' => 'Текстовая метка',])
            ->end()
            ->with('Изображения', ['class' =>'col-xs-12'])
            ->add('gallery', 'string', array('template' => 'ZIMkaRUCoreBundle:IndexPageAdmin:show_field_gallery_thumb.html.twig'))
            ->end()
            ->end()


            ->tab('Контакты')
            ->with('Контент', ['class' =>'col-lg-6 col-xs-12 col-lg-offset-3'])
            ->add('contactsHeader', null, ['label' => 'Заглавие',])
            ->add('contactsPhone', null, ['label' => 'Телефон',])
            ->add('contactsEmail', null, ['label' => 'Email',])
            ->end()
            ->with('Изображение телефона', ['class' =>'col-lg-6 col-xs-12'])
            ->add('contactsPhoneImage', 'string', array('template' => 'ZIMkaRUCoreBundle:IndexPageAdmin:show_field_image_thumb.html.twig'))
            ->end()
            ->with('Изображение Email', ['class' =>'col-lg-6 col-xs-12'])
            ->add('contactsEmailImage', 'string', array('template' => 'ZIMkaRUCoreBundle:IndexPageAdmin:show_field_image_thumb.html.twig'))
            ->end()
            ->end()


            ->tab('SEO')
            ->with('Контент', ['class' =>'col-lg-6 col-xs-12 col-lg-offset-3'])
            ->add('title')
            ->add('keywords')
            ->add('description')
            ->end()
            ->end()
        ;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('clone', $this->getRouterIdParameter().'/clone');
        $collection->add('active', $this->getRouterIdParameter().'/active');
    }
}