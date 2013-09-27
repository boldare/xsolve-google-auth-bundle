<?php

namespace Xsolve\GoogleAuthBundle\Exception;

use Exception;


class FailureAuthorizedException extends Exception {

  protected $message = "XSolve Google Auth couldn't authorize user";
  protected $code = 401;

}