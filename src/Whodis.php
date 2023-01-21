<?php

namespace MallardDuck\Whodis;

use MallardDuck\Whodis\Exceptions\MissingArgException;
use MallardDuck\Whodis\Exceptions\UnknownWhoisException;
use MallardDuck\Whois\Client;
use MallardDuck\Whois\Exceptions\SocketClientException;
use MallardDuck\WhoisDomainList\Exceptions\UnknownTopLevelDomain;
use MallardDuck\WhoisDomainList\PslServerLocator;
use Pdp\ResolvedDomainName;
use Pdp\Rules;
use Pdp\Suffix;
use RuntimeException;

final class Whodis
{
    private Rules $domainParser;
    private PslServerLocator $whoisLocator;

    /**
     * Construct the Whois Client Class.
     */
    public function __construct()
    {
        $this->domainParser = Rules::fromPath(dirname(__DIR__) . '/blobs/public_suffix_list.dat');
        $this->whoisLocator = new PslServerLocator();
    }

    /**
     * Performs a Whois look up on the domain provided.
     *
     * @param string $domain The domain being looked up via whois.
     * @param int    $follow Number of times to follow Whois Server redirects.
     * @param bool   $fullResults Configures response for either the final response or all responses [Default: false].
     *
     * @return string         The output of the Whois look up.
     * @throws UnknownTopLevelDomain
     * @throws SocketClientException|UnknownWhoisException
     */
    public function lookup(
        string $domain,
        int $follow = 2,
        bool $fullResults = false
    ): string {
        if (empty($domain)) {
            throw new MissingArgException('Must provide a domain name when using lookup method.');
        }
        if ($follow < 1) {
            throw new RuntimeException('The follow number must be a positive integer.');
        }

        // 1. Parse the domain:
        //  a. Determine the searchable hostname
        //  b. Convert searchable hostname from IDN to ascii with idn_to_ascii
        $parsedDomain = $this->parseWhoisDomain($domain);
        // 2. Determine what the TLD for the domain is
        $domainTLD = $this->getTopLevelDomain($parsedDomain);
        // 3. Find the whois server for the TLD, or default to IANA.
        $whoisServer = 'whois.iana.org';
        if ($domainTLD !== '') {
            $whoisServer = $this->whoisLocator->getWhoisServer($domainTLD);
        }
        $results = [];
        // 4. Make a requests (per follow option) to the whois server
        while ($follow > 1) {
            $whoisClient = new Client($whoisServer);
            $results[] = $whoisClient->makeRequest($parsedDomain);
            $follow--;
        };

        if ($fullResults) {
            $concat = PHP_EOL;
            return implode($concat, $results);
        }

        return $results[array_key_last($results)];
        // 5. Parse the response from the whois server (TODO: V2)
    }

    /**
     * Takes the user provided domain and parses then encodes just the registerable domain.
     *
     * @param string $domain The user provided domain.
     *
     * @return string Returns the parsed domain.
     * @throws MissingArgException
     * @throws UnknownWhoisException
     */
    protected function parseWhoisDomain(string $domain): string
    {
        $processedDomain = $this->getSearchableHostname($domain);
        if ('' === $processedDomain) {
            throw new UnknownWhoisException("Unable to parse input to searchable hostname.");
        }

        // Punycode the domain if it's Unicode
        if ("UTF-8" === mb_detect_encoding($domain)) {
            $processedDomain = idn_to_ascii($processedDomain);
        }

        return $processedDomain;
    }

    /**
     * Uses the League Uri Hosts component to get the search able hostname in PHP 5.6 and 7.
     *
     * @param string $domain The domain or IP being looked up.
     *
     * @return string
     */
    protected function getSearchableHostname(string $domain): string
    {
        /**
         * @var ResolvedDomainName $resolvedDomain
         */
        $resolvedDomain = $this->domainParser->resolve(trim($domain, '.'));

        $registerableDomain = $resolvedDomain->registrableDomain();
        // When this is an empty string, we'll try to parse the input as a TLD...
        if ($registerableDomain->toString() === '') {
            if (
                Suffix::fromIANA(trim($domain, '.'))->isKnown() ||
                Suffix::fromICANN(trim($domain, '.'))->isKnown()
            ) {
                return trim($domain, '.');
            }
        }

        // Attempt to parse the domains Host component and get the registrable parts.
        return $registerableDomain->toString();
    }

    private function getTopLevelDomain(string $domain): string
    {
        /**
         * @var ResolvedDomainName $resolvedDomain
         */
        $resolvedDomain = $this->domainParser->resolve($domain);
        return $resolvedDomain->suffix()->toString();
    }
}
