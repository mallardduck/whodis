<?php
namespace MallardDuck\Whodis;

class WhodisResponse
{


    /**
     * The parser service class.
     *
     * @var
     */
   private $parserService;

    private $rootResponse;
    private $registrarResponse;

    /**
     * Construct the Whodis Response Class.
     */
    public function __construct(string $root, string $registrar)
    {
        $this->rootResponse = $root;
        $this->registrarResponse = $registrar;
        //$this->parserService = new ParserService;
    }

    public function getRootResponse()
    {
        return $this->rootResponse;
    }

    public function getRegistrarResponse()
    {
        return $this->registrarResponse;
    }

    public function getRawResponses()
    {
        return $this->rootResponse . "\r\n" . $this->registrarResponse;
    }
}
