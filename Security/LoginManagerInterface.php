<?php

namespace Xsolve\GoogleAuthBundle\Security;

use Symfony\Component\HttpFoundation\Request;

interface LoginManagerInterface
{
    public function loginUser(Request $request);
}
