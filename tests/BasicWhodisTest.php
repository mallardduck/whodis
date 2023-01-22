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

it('can whois lookup google.com', function () {
    $client = new Whodis();
    expect($client->lookup('google.com'))
        ->toBeString()
        ->toContain(
            'Domain Name: google.com',
            'Registry Domain ID: 2138514_DOMAIN_COM-VRSN',
            'Registrar: MarkMonitor, Inc.',
            'Admin Organization: Google LLC'
        );
});

it('can whois lookup google.com with one follow', function () {
    $client = new Whodis();
    expect($client->lookup('google.com', 1))
        ->toBeString()
        ->toContain(
            'Domain Name: GOOGLE.COM',
            'Registry Domain ID: 2138514_DOMAIN_COM-VRSN',
            'Registrar: MarkMonitor Inc.'
        );
});

it('can whois rootLookup google.com with one follow', function () {
    $client = new Whodis();
    expect($client->rootLookup('google.com', 1))
        ->toBeString()
        ->toContain(
            'Domain Name: GOOGLE.COM',
            'Registry Domain ID: 2138514_DOMAIN_COM-VRSN',
            'Registrar: MarkMonitor Inc.',
            '>>> Last update of whois database:',
        );
});

it('can whois lookup github.com', function () {
    $client = new Whodis();
    expect($client->lookup('github.com'))
        ->toBeString()
        ->toContain(
            'Domain Name: github.com',
            'Registry Domain ID: 1264983250_DOMAIN_COM-VRSN',
            'Registrar: MarkMonitor, Inc.',
            'Admin Organization: GitHub, Inc.',
        );
});

it('can whois lookup suse.com with (up to) 5 follows', function () {
    $client = new Whodis();
    expect($client->lookup('suse.com', 5))
        ->toBeString()
        ->toContain(
            'Domain Name: suse.com',
            'Registry Domain ID: 825987_DOMAIN_COM-VRSN',
            'Registrar: MarkMonitor, Inc.',
            'Admin Organization: SUSE Software Solutions Germany GmbH',
        );
});

it('can whois lookup suse.de with full results', function () {
    $client = new Whodis();
    expect($client->lookup('suse.de', fullResults:  true))
        ->toBeString()
        ->toContain(
            'Domain: suse.de',
            'Status: connect',
            'Nserver: ns-1130.awsdns-13.org',
        );
});

it('can whois rootLookup suse.com with full results', function () {
    $client = new Whodis();
    expect($client->rootLookup('suse.com', fullResults:  true))
        ->toBeString()
        ->toContain(
            'domain:       COM',
            'organisation: VeriSign Global Registry Services',
            'Domain Name: suse.com',
            'Registry Domain ID: 825987_DOMAIN_COM-VRSN',
            'Registrar: MarkMonitor Inc.',
            '>>> Last update of whois database:',
            'Domain Name: suse.com',
            'Registry Domain ID: 825987_DOMAIN_COM-VRSN',
            'Registrar: MarkMonitor, Inc.',
            'Admin Organization: SUSE Software Solutions Germany GmbH',
        );
});
