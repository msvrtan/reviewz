<?php

namespace spec\Miro;

use Miro\CreateUserHandler;
use PhpSpec\ObjectBehavior;

class CreateUserHandlerSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(CreateUserHandler::class);
    }
}
