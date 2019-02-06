<?php

use Clue\Redis\Server\Storage;
use Clue\Redis\Server\Business\Strings;

class StringsTest extends TestCase
{
    private $business;
    private $storage;

    public function setUp()
    {
        $this->storage = new Storage();
        $this->business = new Strings($this->storage);
    }

    public function testStorage()
    {
        $this->assertTrue($this->business->set('test', 'value'));
        $this->assertTrue($this->storage->hasKey('test'));
        $this->assertEquals('value', $this->business->get('test'));
    }

    public function testSetNx()
    {
        $this->assertEquals(1, $this->business->setnx('test', 'value1'));
        $this->assertEquals(0, $this->business->setnx('test', 'value2'));
        $this->assertEquals('value1', $this->business->get('test'));
    }

    public function testStorageParams()
    {
        $this->assertNull($this->business->set('test', 'value', 'xx'));
        $this->assertNull($this->business->get('test'));

        $this->assertTrue($this->business->set('test', 'value', 'nx'));
        $this->assertEquals('value', $this->business->get('test'));

        $this->assertNull($this->business->set('test', 'newvalue', 'nx'));
        $this->assertEquals('value', $this->business->get('test'));

        $this->assertTrue($this->business->set('test', 'newvalue', 'xx'));
        $this->assertEquals('newvalue', $this->business->get('test'));
    }

    public function testIncrement()
    {
        $this->assertEquals(1, $this->business->incr('counter'));
        $this->assertEquals(2, $this->business->incr('counter'));

        $this->assertEquals(12, $this->business->incrby('counter', 10));

        $this->assertEquals(11, $this->business->decr('counter'));

        $this->assertEquals(9, $this->business->decrby('counter', 2));
    }

    /**
     *
     * @expectedException Clue\Redis\Server\InvalidDatatypeException
     */
    public function testIncrementInvalid()
    {
        $this->business->set('a', 'hello');
        $this->business->incr('a');
    }

    public function testMultiGetSet()
    {
        $this->assertEquals(array(null, null), $this->business->mget('a', 'b'));

        $this->assertTrue($this->business->mset('a', 'value1', 'c', 'value2'));

        $this->assertEquals(array('value1', null, 'value2'), $this->business->mget('a', 'b', 'c'));
    }

    public function testMsetNx()
    {
        $this->assertTrue($this->business->msetnx('a', 'b', 'c', 'd'));
        $this->assertEquals(array('b', 'd'), $this->business->mget('a', 'c'));

        $this->assertFalse($this->business->msetnx('b', 'c', 'c', 'e'));
    }

    /**
     * @expectedException Exception
     */
    public function testMsetInvalidNumberOfArguments()
    {
        $this->business->mset('a', 'b', 'c');
    }

    public function testStrlen()
    {
        $this->assertEquals(0, $this->business->strlen('key'));

        $this->business->set('key', 'value');

        $this->assertEquals(5, $this->business->strlen('key'));
    }

    public function testAppend()
    {
        $this->assertEquals(5, $this->business->append('test', 'value'));
        $this->assertEquals('value', $this->business->get('test'));

        $this->assertEquals(8, $this->business->append('test', '123'));
        $this->assertEquals('value123', $this->business->get('test'));
    }

    /**
     * @expectedException UnexpectedValueException
     */
    public function testAppendListFails()
    {
        $list = $this->storage->getOrCreateList('list');
        $list->push('value');

        $this->business->append('list', 'invalid');
    }

    public function testGetrange()
    {
        $this->assertTrue($this->business->set('test', 'This is a string'));

        $this->assertEquals('This', $this->business->getrange('test', 0, 3));
        $this->assertEquals('ing', $this->business->getrange('test', -3, -1));
        $this->assertEquals('This is a string', $this->business->getrange('test', 0, -1));
        $this->assertEquals('string', $this->business->getrange('test', 10, 100));
        $this->assertEquals('', $this->business->getrange('test', 100, 200));

        $this->assertEquals('', $this->business->getrange('unknown', 0, 3));
    }

    public function testSetrange()
    {
        $this->assertEquals(11, $this->business->setrange('test', 6, 'world'));
        $this->assertEquals("\0\0\0\0\0\0world", $this->business->get('test'));

        $this->assertEquals(11, $this->business->setrange('test', 0, 'hello'));
        $this->assertEquals("hello\0world", $this->business->get('test'));

        $this->assertEquals(12, $this->business->setrange('test', 5, ' world!'));
        $this->assertEquals("hello world!", $this->business->get('test'));
    }

    public function testGetset()
    {
        $this->assertEquals(null, $this->business->getset('test', 'a'));
        $this->assertEquals('a', $this->business->getset('test', 'b'));
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage ERR value is not an integer or out of range
     * @dataProvider provideInvalidIntegerArgument
     */
    public function testInvalidIntegerArgument($method, $arg0)
    {
        $args = func_get_args();
        unset($args[0]);

        call_user_func_array(array($this->business, $method), $args);
    }

    public function provideInvalidIntegerArgument()
    {
        return array(
            array('incrby', 'key', 'invalid'),
            array('decrby', 'key', 'invalid'),
            array('set', 'key', 'value', 'EX', 'invalid'),
            array('setex', 'key', 'invalid', 'value'),
            array('psetex', 'key', 'invalid', 'value'),
        );
    }
}
