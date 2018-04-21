<?php

namespace spec\Miro;

use Miro\CreateUser;
use PhpSpec\ObjectBehavior;

class CreateUserSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(CreateUser::class);
    }
}
