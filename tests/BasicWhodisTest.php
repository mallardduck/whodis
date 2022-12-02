<?php

use MallardDuck\Whodis\Whodis;

it('can create a client', function () {
    expect(new Whodis())
        ->toBeObject()
        ->toBeInstanceOf(Whodis::class);
});

it('can whois lookup .com TLD', function () {
    $client = new Whodis();
    expect($client->lookup('.com.'))
        ->toBeString();
});

it('can whois lookup google.com TLD', function () {
    $client = new Whodis();
    expect($client->lookup('google.com'))
        ->toBeString();
});
