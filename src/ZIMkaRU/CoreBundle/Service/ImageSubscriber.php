<?php
/**
 * Created by PhpStorm.
 * User: voronkov_vs
 * Date: 04.08.2016
 * Time: 17:00
 */

namespace ZIMkaRU\CoreBundle\Service;

use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use ZIMkaRU\CoreBundle\Entity\ImageBase;

class ImageSubscriber implements EventSubscriber
{
    protected $croppedDir;
    protected $thumbsDir;
    protected $webDir;
    protected $galleryDir;

    public function __construct($croppedDir, $thumbsDir, $container, $webDirName, $galleryDir)
    {
        $this->croppedDir = $croppedDir;
        $this->thumbsDir = $thumbsDir;
        $this->galleryDir = $galleryDir;

        $dir = $container->get('kernel')->getRootdir();
        $dir = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' ? str_replace('\\', '/', $dir) : $dir;
        $this->webDir = $dir . '/../' . $webDirName;
    }

    public function getSubscribedEvents()
    {
        return array(
            'prePersist',
            'postPersist',
            'preUpdate',
            'postUpdate',
        );
    }

    public function prePersist(LifeCycleEventArgs $args)
    {
    }

    public function postPersist(LifeCycleEventArgs $args)
    {
    }

    public function preUpdate(LifeCycleEventArgs $args)
    {
        $this->removeImage($args);
    }

    public function postUpdate(LifeCycleEventArgs $args)
    {
    }

    private function removeFile($file)
    {
        if (file_exists($file) && is_file($file)) {
            unlink($file);
        }
    }

    private function removeThumbImage ($file, $path)
    {
        $path = $path . '/' . $this->croppedDir . '/' . $this->thumbsDir;
        $patternReplace = '/^' . $this->croppedDir . '\//i';
        $file = preg_replace($patternReplace, '', $file, 1);

        if ($handle = opendir($path)) {
            while (false !== ($entry = readdir($handle))) {
                $pattern = '/' . $file . '$/i';

                if ($entry != "." && $entry != ".." && preg_match($pattern, $entry)) {
                    $this->removeFile($path . '/' . $entry);
                }
            }
            closedir($handle);
        }
    }

    private function getPathImageCropped($obj)
    {
        return $this->webDir . '/' . $obj->getUploadDir();
    }

    private function getPathImageGallery($obj)
    {
        return $this->webDir . '/' . $obj->getUploadDir() . '/' . $this->galleryDir;
    }

    private function removeImage(LifeCycleEventArgs $args)
    {
        $entity = $args->getObject();

        if ($entity instanceof ImageBase) {
//            $entityManager = $args->getObjectManager();
            $imageFields = $entity->getImageFields();

            foreach($imageFields as $imageField) {

                if($args->hasChangedField($imageField) &&
                    null !== ($imageNewEntity = $args->getNewValue($imageField)) &&
                    null !== ($imageOldEntity = $args->getOldValue($imageField))) {
                    if(is_array($imageOldEntity)) {
                        foreach($imageOldEntity as $galleryImage) {
                            $noRemove = false;

                            foreach($imageNewEntity as $galleryNewImage) {
                                $noRemove = $galleryImage == $galleryNewImage;
                                if($noRemove) break;
                            }

                            if($noRemove) continue;

                            $path = $this->getPathImageGallery($entity);
                            $image = $path . '/' . $galleryImage;

                            $this->removeFile($image);
                            $this->removeThumbImage($galleryImage, $path);
                        }
                    } else {
                        $path = $this->getPathImageCropped($entity);
                        $image = $path . '/' . $imageOldEntity;

                        $this->removeFile($image);
                        $this->removeThumbImage($imageOldEntity, $path);
                    }
                }
            }
        }
    }
}