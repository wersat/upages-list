<?php

    class Framework_MockObject_Invocation_StaticTest extends PHPUnit_Framework_TestCase
    {
        public function testConstructorRequiresClassAndMethodAndParameters()
        {
            new PHPUnit_Framework_MockObject_Invocation_Static('FooClass', 'FooMethod', ['an_argument']);
        }

        public function testAllowToGetClassNameSetInConstructor()
        {
            $invocation = new PHPUnit_Framework_MockObject_Invocation_Static('FooClass', 'FooMethod', ['an_argument']);
            $this->assertSame('FooClass', $invocation->className);
        }

        public function testAllowToGetMethodNameSetInConstructor()
        {
            $invocation = new PHPUnit_Framework_MockObject_Invocation_Static('FooClass', 'FooMethod', ['an_argument']);
            $this->assertSame('FooMethod', $invocation->methodName);
        }

        public function testAllowToGetMethodParametersSetInConstructor()
        {
            $expectedParameters = [
                'foo',
                5,
                ['a', 'b'],
                new StdClass,
                null,
                false
            ];
            $invocation         = new PHPUnit_Framework_MockObject_Invocation_Static('FooClass', 'FooMethod',
                $expectedParameters);
            $this->assertSame($expectedParameters, $invocation->parameters);
        }

        public function testConstructorAllowToSetFlagCloneObjectsInParameters()
        {
            $parameters   = [new StdClass];
            $cloneObjects = true;
            $invocation   = new PHPUnit_Framework_MockObject_Invocation_Static('FooClass', 'FooMethod', $parameters,
                $cloneObjects);
            $this->assertEquals($parameters, $invocation->parameters);
            $this->assertNotSame($parameters, $invocation->parameters);
        }
    }
