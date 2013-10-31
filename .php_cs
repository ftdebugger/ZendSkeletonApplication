<?php

$finder = Symfony\CS\Finder\DefaultFinder::create()
    ->exclude("vendor")
    ->exclude("data")
    ->exclude("bin")
    ->exclude("vagrant")
    ->in(__DIR__ . '/module');

return Symfony\CS\Config\Config::create()
    ->fixers(
        array(
             'indentation',
             'linefeed',
             'trailing_spaces',
             'unused_use',
             'short_tag',
             'return',
             'visibility',
             'php_closing_tag',
             'braces',
             'extra_empty_lines',
             'function_declaration',
             'include',
             'controls_spaces',
             'psr0',
             'elseif',
             'eof_ending'
        )
    )
    ->finder($finder);