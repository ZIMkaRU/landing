<?php
/**
 * Created by PhpStorm.
 * User: voronkov_vs
 * Date: 16.11.2016
 * Time: 10:21
 */

namespace ZIMkaRU\CoreBundle\Twig;


use Comur\ImageBundle\Twig\ThumbExtension;

class HolderJSExtension extends \Twig_Extension
{
    private $thumbExtension;

    public function __construct(ThumbExtension $thumbExtension)
    {
        $this->thumbExtension = $thumbExtension;
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('thumbOrHolder', array($this, 'getThumbOrHolder')),
            new \Twig_SimpleFilter('imageOrHolder', array($this, 'getImageOrHolder')),
        );
    }

    public function getHolder($origFilePath, $width, $height, $imagePath)
    {
        if (!$origFilePath) {
            return "holder.js/" . $width . "x" . $height . "?random=yes&auto=yes&textmode=exact";
        } elseif (preg_match('/holder.js/', $origFilePath)) {
            return "holder.js/" . $width . "x" . $height . "?random=yes&auto=yes&textmode=exact";
        } else {
            return $imagePath;
        }
    }

    public function getThumbOrHolder($origFilePath, $width, $height)
    {
        return $this->getHolder(
            $origFilePath,
            $width,
            $height,
            $this->thumbExtension->getThumb($origFilePath, $width, $height)
        );
    }

    public function getImageOrHolder($origFilePath, $width, $height)
    {
        return $this->getHolder(
            $origFilePath,
            $width,
            $height,
            $origFilePath
        );
    }

    public function getName()
    {
        return 'zimkaru_image_thumb_holder_extension';
    }

    public function getGlobals()
    {
        return $this->thumbExtension->getGlobals();
    }
}