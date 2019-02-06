<?php

use Clue\Redis\Server\Storage;
use Clue\Redis\Server\InvalidDatatypeException;

class StorageTest extends TestCase
{
    private $storage;

    public function setUp()
    {
        $this->storage = new Storage();
    }

    public function testHasSetUnset()
    {
        $this->assertFalse($this->storage->hasKey('key'));

        $this->storage->setString('key', 'value');
        $this->assertTrue($this->storage->hasKey('key'));

        $this->storage->unsetKey('key');
        $this->assertFalse($this->storage->hasKey('key'));

    }

    public function testString()
    {
        $this->assertEquals(null, $this->storage->getStringOrNull('key'));

        $this->storage->setString('key', 'value');

        $this->assertEquals('value', $this->storage->getStringOrNull('key'));
    }

    public function testList()
    {
        // empty list will be created on first access
        $list = $this->storage->getOrCreateList('list');
        $this->assertInstanceOf('SplDoublyLinkedList', $list);
        $this->assertTrue($list->isEmpty());

        // further calls return the same list
        $this->assertSame($list, $this->storage->getOrCreateList('list'));
    }

    public function testKeys()
    {
        $this->assertEquals(array(), $this->storage->getAllKeys());
        $this->assertNull($this->storage->getRandomKey());

        $this->storage->setString('a', '1');
        $this->storage->setString('b', '2');

        $this->assertEquals(array('a', 'b'), $this->storage->getAllKeys());

        $this->storage->setTimeout('b', 0);

        $this->assertEquals(array('a'), $this->storage->getAllKeys());
        $this->assertEquals('a', $this->storage->getRandomKey());
    }

    /**
     * @expectedException Clue\Redis\Server\InvalidDatatypeException
     */
    public function testInvalidList()
    {
        $this->storage->setString('string', 'value');
        $this->storage->getOrCreateList('string');
    }

    /**
     * @expectedException Clue\Redis\Server\InvalidDatatypeException
     */
    public function testInvalidString()
    {
        $this->storage->getOrCreateList('list');
        $this->storage->getStringOrNull('list');
    }
}
