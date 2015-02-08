<?php

namespace BRO\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class BROUserBundle extends Bundle
{
    
    public function getParent()
    {
        return 'SonataUserBundle';
    }
}
