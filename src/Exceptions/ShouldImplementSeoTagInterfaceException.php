<?php

namespace MichaelRubel\SeoManager\Exceptions;

class ShouldImplementSeoTagInterfaceException extends \Exception
{
    protected $message = 'SeoTag model should implement MichaelRubel\SeoManager\Models\SeoTagContract';
}