<?php
namespace MallardDuck\Whodis;

use MallardDuck\Whois\AbstractClient;
use MallardDuck\Whodis\ParserService;

/**
 * The Whois Client Class.
 *
 * @author mallardduck <dpock32509@gmail.com>
 *
 * @copyright lucidinternets.com 2018
 *
 * @version 0.0.0
 */
class Whodis extends AbstractClient
{

    /**
     * Construct the Whois Client Class.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Performs a Whois look up on the domain provided.
     * @param  string $domain The domain being looked up via whois.
     *
     * @return string         The output of the Whois look up.
     */
    public function lookup($domain = '')
    {
        if (empty($domain)) {
            throw new MissingArgException("Must provide a domain name when using lookup method.");
        }
        $this->parseWhoisDomain($domain);

        // Get the domains whois server.
        $whoisServer = $this->tldLocator->getWhoisServer($this->parsedDomain);

        // Get the full output of the whois lookup.
        $rootResponse = $this->makeWhoisRequest($this->parsedDomain, $whoisServer);

        // Find the Registrar whois server and look up the domain there.
        $registrarServer = $this->findWhoisServer($rootResponse);
        $registrarResponse = $this->makeWhoisRequest($this->parsedDomain, $registrarServer);

        $response = new WhodisResponse($rootResponse, $registrarResponse);

        return $response->getRawResponses();
    }

    private function findWhoisServer(string $resultString)
    {
        $results = preg_match_all("/Registrar WHOIS Server: (.*)\\r\\n/", $resultString, $output_array);
        if ($results == 1) {
            return $output_array[1][0];
        }
        return false;
    }

}
