<?php

use MallardDuck\Whodis\Exceptions\MissingArgException;

it('will throw an exception for empty string input', function () {
    $client = new MallardDuck\Whodis\Whodis();
    $client->lookup('');
})->throws(MissingArgException::class);
