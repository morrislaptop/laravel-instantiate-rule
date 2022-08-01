<?php

use Morrislaptop\LaravelInstantiateRule\InstantiateRule;

it('passes a basic object with no params', function ()
{
    $class = new class {
        public function __construct() {}
    };

    $rule = new InstantiateRule($class::class);

    $this->assertTrue($rule->passes('test', 42));
});

it('passes a valid test with param', function ()
{
    $class = new class(42) {
        public function __construct(private int $number) {}
    };

    $rule = new InstantiateRule($class::class);

    $this->assertTrue($rule->passes('test', 42));
});

it('passes a valid test with param with custom constructor', function ()
{
    $class = new class(42) {
        public function __construct(private int $number) {}
        public static function createFromString(string $number) {
            return new self($number === 'Forty Two' ? 42 : $number);
        }
    };

    $rule = new InstantiateRule($class::class, 'createFromString');

    $this->assertTrue($rule->passes('test', 'Forty Two'));
});

it('rejects a custom constructor', function ()
{
    $class = new class(42) {
        public function __construct(private int $number) {}
        public static function createFromBool(bool $throw) {
            throw_if($throw, new InvalidArgumentException('Throw me!'));
            return new self(42);
        }
    };

    $rule = new InstantiateRule($class::class, 'createFromBool');

    $this->assertFalse($rule->passes('test', 'Forty Two'));
    $this->assertEquals('Throw me!', $rule->message());
});

it('passes a valid test with multiple params', function ()
{
    $class = new class('Unit 1', 'Test St') {
        public function __construct(private string $line1, private string $line2) {}
    };

    $rule = new InstantiateRule($class::class);

    $this->assertTrue($rule->passes('test', ['line1' => 'line1', 'line2' => 'line2']));
});

it('rejects a constructor which throws with param', function ()
{
    $class = new class(42) {
        public function __construct(private int $number) {
            throw_if($number !== 42, new InvalidArgumentException('Haha nice try.'));
        }
    };

    $rule = new InstantiateRule($class::class);

    $this->assertFalse($rule->passes('test', 7));
    $this->assertEquals('Haha nice try.', $rule->message());
});

it('rejects the wrong parameter type', function ()
{
    $class = new class(42) {
        public function __construct(private int $number) {}
    };

    $rule = new InstantiateRule($class::class);

    $this->assertFalse($rule->passes('test', 'hi!'));
    $this->assertStringContainsString('must be of type int, string given', $rule->message());
});

it('rejects a contructor which throws multiple params', function ()
{
    $class = new class(42, 42) {
        public function __construct(private int $number1, private int $number2) {
            throw_if($number2 !== 42, new InvalidArgumentException('Still trying?'));
        }
    };

    $rule = new InstantiateRule($class::class);

    $this->assertFalse($rule->passes('test', [42, 43]));
    $this->assertStringContainsString('Still trying?', $rule->message());
});
