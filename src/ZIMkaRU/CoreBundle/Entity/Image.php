<?php
/**
 * Created by PhpStorm.
 * User: voronkov_vs
 * Date: 12.07.2016
 * Time: 16:33
 */

namespace ZIMkaRU\CoreBundle\Entity;

abstract class Image implements ImageBase
{
    public function getUploadRootDir()
    {
        // absolute path to your directory where images must be saved
        $dir = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' ? str_replace('\\', '/', __DIR__) : __DIR__;
        return $dir . '/../../../../web/' . $this->getUploadDir();
    }

    public function getUploadDir()
    {
        return 'uploads/image';
    }

    public function getAbsolutePath($field, $flag = false)
    {
        $fieldName = 'get' . $field;
        $image = $flag ? 'gallery/' . $field : $this->$fieldName();

        return null === $this->$image ? null : $this->getUploadRootDir() . '/' . $image;
    }

    public function getWebPath($field, $flag = false)
    {
        $fieldName = 'get' . $field;
        $image = $flag ? 'gallery/' . $field : $this->$fieldName();

        return null === $image ? null : '/' . $this->getUploadDir() . '/' . $image;
    }
}
