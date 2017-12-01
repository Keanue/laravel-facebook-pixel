<?php

namespace Keanue\LaravelFacebookPixel;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Keanue\LaravelFacebookPixel\LaravelFacebookPixel
 */
class LaravelFacebookPixelFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'facebook-pixel';
    }
}
