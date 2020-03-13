<?php

declare(strict_types=1);

namespace ConfigOne\MonologMaskingFormatter\Tests;

use ConfigOne\MonologMaskingFormatter\Tests\Monolog\TestMaskingFormatter;
use PHPUnit\Framework\TestCase;

class MaskingFormatterTest extends TestCase
{
    /**
     * @var TestMaskingFormatter
     */
    private $formatter;

    protected function setUp(): void
    {
        $this->formatter = new TestMaskingFormatter();
        $this->formatter->setMaskedFields(['email', 'password']);
    }

    public function testCanMaskArray()
    {
        $record = [
            'some' => 'value',
            'email' => 'sensitive',
            'nested' => ['foo' => ['password' => '1234']]
        ];

        $result = $this->formatter->format($record);

        $this->assertEquals($this->formatter->getMask(), $result['email']);
        $this->assertEquals($this->formatter->getMask(), $result['nested']['foo']['password']);

        $this->assertEquals($record['some'], $result['some']);
    }

    public function testJsonSerializable()
    {
        $object = new class implements \JsonSerializable {
            public $email = 'sensitive';
            public $foo = 'bar';

            public function jsonSerialize()
            {
                return [
                    'email' => $this->email,
                    'foo' => $this->foo
                ];
            }
        };

        $record = [
            'some' => 'value',
            'email' => 'sensitive',
            'object' => $object
        ];

        $result = $this->formatter->format($record);

        $this->assertEquals($this->formatter->getMask(), $result['email']);
        $this->assertEquals($this->formatter->getMask(), $result['object']['email']);

        $this->assertEquals($object->foo, $result['object']['foo']);
        $this->assertEquals($record['some'], $result['some']);
    }
}