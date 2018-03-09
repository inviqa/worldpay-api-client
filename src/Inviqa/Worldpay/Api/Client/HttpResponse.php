<?php

namespace Inviqa\Worldpay\Api\Client;

class HttpResponse
{
    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $cookie;

    private function __construct()
    {
    }

    public static function fromContentAndCookie(string $content, $cookie = "")
    {
        $instance = new self;
        $instance->content = $content;
        $instance->cookie = $cookie;

        return $instance;
    }

    public function content()
    {
        return $this->content;
    }

    public function cookie()
    {
        return $this->cookie;
    }
}
