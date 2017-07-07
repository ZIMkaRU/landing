<?php

namespace ZIMkaRU\CoreBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ZIMkaRUCoreBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'SonataUserBundle';
    }
}
