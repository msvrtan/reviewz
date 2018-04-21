<?php

namespace RMiller\BehatSpec\Extension\PhpSpecExtension\Process;

interface CommandRunner
{
    /**
     * @param string|false $path
     */
    public function runCommand($path, $args);

    /**
     * @return bool
     */
    public function isSupported();
}
