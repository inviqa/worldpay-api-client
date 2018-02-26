<?php

namespace spec\Inviqa\Worldpay\Api;

use Inviqa\Worldpay\Api\Exception\InvalidRequestParameterException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class XmlNodeDefaultsSpec extends ObjectBehavior
{
    function it_throws_an_exception_for_an_empty_value()
    {
        $this->beConstructedWith("");
        $this->shouldThrow(InvalidRequestParameterException::class)->duringInstantiation();

        $this->beConstructedWith();
        $this->shouldThrow(InvalidRequestParameterException::class)->duringInstantiation();
    }

    function it_returns_a_camel_case_class_name()
    {
        $this->beConstructedWith(Argument::any());

        $this->xmlLabel()->shouldBe("xmlNodeDefaults");
    }
}
