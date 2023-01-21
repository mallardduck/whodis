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

it('can whois lookup google.com with one follow', function () {
    $client = new Whodis();
    $googleWhoisResults = $client->lookup('google.com', 1);
    \Spatie\Snapshots\assertMatchesTextSnapshot(filter_update_at($googleWhoisResults));
});

it('can whois rootLookup google.com with one follow', function () {
    $client = new Whodis();
    $googleWhoisResults = $client->rootLookup('google.com', 1);
    \Spatie\Snapshots\assertMatchesTextSnapshot(filter_update_at($googleWhoisResults));
});

it('can whois lookup google.com', function () {
    $client = new Whodis();
    $googleWhoisResults = $client->lookup('google.com');
    \Spatie\Snapshots\assertMatchesTextSnapshot(filter_update_at($googleWhoisResults));
});

it('can whois lookup google.com with 5 follows', function () {
    $client = new Whodis();
    $googleWhoisResults = $client->lookup('google.com', 5);
    \Spatie\Snapshots\assertMatchesTextSnapshot(filter_update_at($googleWhoisResults));
});

it('can whois lookup google.com with full results', function () {
    $client = new Whodis();
    $googleWhoisResults = $client->lookup('google.com', 5, true);
    \Spatie\Snapshots\assertMatchesTextSnapshot(filter_update_at($googleWhoisResults));
});

it('can whois rootLookup google.com with full results', function () {
    $client = new Whodis();
    $googleWhoisResults = $client->rootLookup('google.com', 5, true);
    \Spatie\Snapshots\assertMatchesTextSnapshot(filter_update_at($googleWhoisResults));
});
