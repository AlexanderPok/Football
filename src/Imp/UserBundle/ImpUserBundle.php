<?php
namespace Imp\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ImpUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
