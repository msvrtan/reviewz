<?php

namespace RMiller\BehatSpec\Extension\PhpSpecRunExtension\Process;

interface CommandRunner
{
    /**
     * @param string|false $path
     * @param string[]     $args
     */
    public function runCommand($path, $args);

    /**
     * @return bool
     */
    public function isSupported();
}
