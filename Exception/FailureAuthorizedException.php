<?php

namespace Xsolve\GoogleAuthBundle\Exception;

use Symfony\Component\HttpKernel\Exception\HttpException;

class FailureAuthorizedException extends HttpException
{

  protected $message = "XSolve Google Auth couldn't authorize user";
  protected $code = 401;

}
