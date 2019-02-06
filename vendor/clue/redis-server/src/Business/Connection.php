<?php

namespace Clue\Redis\Server\Business;

use Clue\Redis\Server\Server;
use OutOfBoundsException;
use UnexpectedValueException;
use Clue\Redis\Server\Client;
use Clue\Redis\Server\AuthInvoker;

class Connection
{
    private $server;
    private $client = null;

    public function __construct(Server $server)
    {
        $this->server = $server;
    }

    // StatusReply
    public function auth($password)
    {
        if ($this->getConfig()->get('requirepass') === '') {
            throw new UnexpectedValueException('ERR Client sent AUTH, but no password is set');
        }

        if ($this->getConfig()->get('requirepass') !== $password) {
            throw new UnexpectedValueException('ERR invalid password');
        }

        $business = $this->getClient()->getBusiness();
        if ($business instanceof AuthInvoker) {
            $this->getClient()->setBusiness($business->getSuccessfulInvoker());
        }

        return true;
    }

    public function x_echo($message)
    {
        return $message;
    }

    // StatusReply
    public function ping()
    {
        return 'PONG';
    }

    // StatusReply
    public function select($index)
    {
        $this->getClient()->setDatabase($this->getDatabaseById($index));

        return true;
    }

    // StatusReply
    public function quit()
    {
        // this command will end the connection and therefor not send any more
        // messages (not even the return code). For this reason we have to send
        // an OK message manually.
        $this->getClient()->write($this->getSerializer()->getStatusMessage('OK'));
        $this->getClient()->end();

        return true;
    }

    public function setClient(Client $client)
    {
        $this->client = $client;
    }

    private function getClient()
    {
        if ($this->client === null) {
            throw new UnexpectedValueException('Invalid state');
        }
        return $this->client;
    }

    private function getSerializer()
    {
        return $this->getClient()->getBusiness()->getSerializer();
    }

    private function getServer()
    {
        return $this->server;
    }

    private function getDatabases()
    {
        return $this->getServer()->getDatabases();
    }

    private function getDatabaseById($id)
    {
        foreach ($this->getDatabases() as $database) {
            if ($database->getId() === $id) {
                return $database;
            }
        }
        throw new OutOfBoundsException('ERR invalid DB index');
    }

    private function getConfig()
    {
        return $this->server->getConfig();
    }
}
