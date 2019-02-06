<?php

use Clue\Redis\Server\Server;
use Clue\Redis\Server\Factory;

class FactoryTest extends TestCase
{
    public function setUp()
    {
        $this->loop = new React\EventLoop\StreamSelectLoop();
        $this->factory = new Factory($this->loop);
    }

    public function testPairAuthRejectDisconnects()
    {
        if (defined('HPHP_VERSION')) {
            $this->markTestSkipped();
        }

        $server = null;

        // bind to a random port on the local interface
        $address = '127.0.0.1:0';

        // start a server that only sends ERR messages.
        $this->factory->createServer($address)->then(function (Server $s) use (&$server) {
            $server = $s;
        });

        $this->assertNotNull($server, 'Server instance must be set by now');
        $this->assertNotNull($server->getLocalAddress());

        // we expect a single single client
        $server->on('connection', $this->expectCallableOnce());

        // we expect the client to close the connection once he receives an ERR messages.
        $server->on('disconnection', $this->expectCallableOnce());

        // end the loop (stop ticking)
        $server->on('disconnection', function() use ($server) {
            $server->close();
        });

        // we expect the factory to fail because of the ERR message.
        $stream = stream_socket_client($server->getLocalAddress());
        fwrite($stream, "invalid\r\n");
        fclose($stream);

        $this->loop->run();
    }

    public function testServerAddressInvalidFail()
    {
        $promise = $this->factory->createServer('invalid address');

        $this->expectPromiseReject($promise);
    }

    public function testServerAddressInUseFail()
    {
        $promise = $this->factory->createServer('tcp://localhost:6379');

        $this->expectPromiseReject($promise);
    }
}
