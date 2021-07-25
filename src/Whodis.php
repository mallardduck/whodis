<?php
namespace MallardDuck\Whodis;

use MallardDuck\Whodis\Exceptions\MissingArgException;

class Whodis
{
    /**
     * Performs a Whois look up on the domain provided.
     * @param  string $domain The domain being looked up via whois.
     *
     * @return string         The output of the Whois look up.
     */
    public function lookup(string $domain)
    {
        if (empty($domain)) {
            throw new MissingArgException("Must provide a domain name when using lookup method.");
        }
    }
}
