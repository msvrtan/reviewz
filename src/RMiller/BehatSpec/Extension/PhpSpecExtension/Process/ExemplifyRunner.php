<?php

namespace RMiller\BehatSpec\Extension\PhpSpecExtension\Process;

interface ExemplifyRunner
{
    public function runExemplifyCommand($className, $methodName);
}
