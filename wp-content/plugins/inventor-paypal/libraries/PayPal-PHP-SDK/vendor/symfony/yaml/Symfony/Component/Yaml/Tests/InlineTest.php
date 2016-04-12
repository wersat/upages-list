<?php
    /*
     * This file is part of the Symfony package.
     *
     * (c) Fabien Potencier <fabien@symfony.com>
     *
     * For the full copyright and license information, please view the LICENSE
     * file that was distributed with this source code.
     */
    namespace Symfony\Component\Yaml\Tests;

    use Symfony\Component\Yaml\Inline;

    class InlineTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @dataProvider getTestsForParse
         */
        public function testParse($yaml, $value)
        {
            $this->assertSame($value, Inline::parse($yaml),
                sprintf('::parse() converts an inline YAML to a PHP structure (%s)', $yaml));
        }

        /**
         * @dataProvider getTestsForParseWithMapObjects
         */
        public function testParseWithMapObjects($yaml, $value)
        {
            $actual = Inline::parse($yaml, false, false, true);
            $this->assertSame(serialize($value), serialize($actual));
        }

        /**
         * @dataProvider getTestsForDump
         */
        public function testDump($yaml, $value)
        {
            $this->assertEquals($yaml, Inline::dump($value),
                sprintf('::dump() converts a PHP structure to an inline YAML (%s)', $yaml));
            $this->assertSame($value, Inline::parse(Inline::dump($value)), 'check consistency');
        }

        public function testDumpNumericValueWithLocale()
        {
            $locale = setlocale(LC_NUMERIC, 0);
            if (false === $locale) {
                $this->markTestSkipped('Your platform does not support locales.');
            }
            $required_locales = ['fr_FR.UTF-8', 'fr_FR.UTF8', 'fr_FR.utf-8', 'fr_FR.utf8', 'French_France.1252'];
            if (false === setlocale(LC_ALL, $required_locales)) {
                $this->markTestSkipped('Could not set any of required locales: ' . implode(", ", $required_locales));
            }
            $this->assertEquals('1.2', Inline::dump(1.2));
            $this->assertContains('fr', strtolower(setlocale(LC_NUMERIC, 0)));
            setlocale(LC_ALL, $locale);
        }

        public function testHashStringsResemblingExponentialNumericsShouldNotBeChangedToINF()
        {
            $value = '686e444';
            $this->assertSame($value, Inline::parse(Inline::dump($value)));
        }

        /**
         * @expectedException \Symfony\Component\Yaml\Exception\ParseException
         */
        public function testParseScalarWithIncorrectlyQuotedStringShouldThrowException()
        {
            $value = "'don't do somthin' like that'";
            Inline::parse($value);
        }

        /**
         * @expectedException \Symfony\Component\Yaml\Exception\ParseException
         */
        public function testParseScalarWithIncorrectlyDoubleQuotedStringShouldThrowException()
        {
            $value = '"don"t do somthin" like that"';
            Inline::parse($value);
        }

        /**
         * @expectedException \Symfony\Component\Yaml\Exception\ParseException
         */
        public function testParseInvalidMappingKeyShouldThrowException()
        {
            $value = '{ "foo " bar": "bar" }';
            Inline::parse($value);
        }

        /**
         * @expectedException \Symfony\Component\Yaml\Exception\ParseException
         */
        public function testParseInvalidMappingShouldThrowException()
        {
            Inline::parse('[foo] bar');
        }

        /**
         * @expectedException \Symfony\Component\Yaml\Exception\ParseException
         */
        public function testParseInvalidSequenceShouldThrowException()
        {
            Inline::parse('{ foo: bar } bar');
        }

        public function testParseScalarWithCorrectlyQuotedStringShouldReturnString()
        {
            $value  = "'don''t do somthin'' like that'";
            $expect = "don't do somthin' like that";
            $this->assertSame($expect, Inline::parseScalar($value));
        }

        /**
         * @dataProvider getDataForParseReferences
         */
        public function testParseReferences($yaml, $expected)
        {
            $this->assertSame($expected, Inline::parse($yaml, false, false, false, ['var' => 'var-value']));
        }

        public function getDataForParseReferences()
        {
            return [
                'scalar'                   => ['*var', 'var-value'],
                'list'                     => ['[ *var ]', ['var-value']],
                'list-in-list'             => ['[[ *var ]]', [['var-value']]],
                'map-in-list'              => ['[ { key: *var } ]', [['key' => 'var-value']]],
                'embedded-mapping-in-list' => ['[ key: *var ]', [['key' => 'var-value']]],
                'map'                      => ['{ key: *var }', ['key' => 'var-value']],
                'list-in-map'              => ['{ key: [*var] }', ['key' => ['var-value']]],
                'map-in-map'               => ['{ foo: { bar: *var } }', ['foo' => ['bar' => 'var-value']]],
            ];
        }

        public function testParseMapReferenceInSequence()
        {
            $foo = [
                'a' => 'Steve',
                'b' => 'Clark',
                'c' => 'Brian',
            ];
            $this->assertSame([$foo], Inline::parse('[*foo]', false, false, false, ['foo' => $foo]));
        }

        /**
         * @expectedException \Symfony\Component\Yaml\Exception\ParseException
         * @expectedExceptionMessage A reference must contain at least one character.
         */
        public function testParseUnquotedAsterisk()
        {
            Inline::parse('{ foo: * }');
        }

        /**
         * @expectedException \Symfony\Component\Yaml\Exception\ParseException
         * @expectedExceptionMessage A reference must contain at least one character.
         */
        public function testParseUnquotedAsteriskFollowedByAComment()
        {
            Inline::parse('{ foo: * #foo }');
        }

        public function getTestsForParse()
        {
            return [
                ['', ''],
                ['null', null],
                ['false', false],
                ['true', true],
                ['12', 12],
                ['-12', -12],
                ['"quoted string"', 'quoted string'],
                ["'quoted string'", 'quoted string'],
                ['12.30e+02', 12.30e+02],
                ['0x4D2', 0x4D2],
                ['02333', 02333],
                ['.Inf', -log(0)],
                ['-.Inf', log(0)],
                ["'686e444'", '686e444'],
                ['686e444', 646e444],
                ['123456789123456789123456789123456789', '123456789123456789123456789123456789'],
                ['"foo\r\nbar"', "foo\r\nbar"],
                ["'foo#bar'", 'foo#bar'],
                ["'foo # bar'", 'foo # bar'],
                ["'#cfcfcf'", '#cfcfcf'],
                ['::form_base.html.twig', '::form_base.html.twig'],
                // Pre-YAML-1.2 booleans
                ["'y'", 'y'],
                ["'n'", 'n'],
                ["'yes'", 'yes'],
                ["'no'", 'no'],
                ["'on'", 'on'],
                ["'off'", 'off'],
                ['2007-10-30', mktime(0, 0, 0, 10, 30, 2007)],
                ['2007-10-30T02:59:43Z', gmmktime(2, 59, 43, 10, 30, 2007)],
                ['2007-10-30 02:59:43 Z', gmmktime(2, 59, 43, 10, 30, 2007)],
                ['1960-10-30 02:59:43 Z', gmmktime(2, 59, 43, 10, 30, 1960)],
                ['1730-10-30T02:59:43Z', gmmktime(2, 59, 43, 10, 30, 1730)],
                ['"a \\"string\\" with \'quoted strings inside\'"', 'a "string" with \'quoted strings inside\''],
                ["'a \"string\" with ''quoted strings inside'''", 'a "string" with \'quoted strings inside\''],
                // sequences
                // urls are no key value mapping. see #3609. Valid yaml "key: value" mappings require a space after the colon
                [
                    '[foo, http://urls.are/no/mappings, false, null, 12]',
                    ['foo', 'http://urls.are/no/mappings', false, null, 12]
                ],
                ['[  foo  ,   bar , false  ,  null     ,  12  ]', ['foo', 'bar', false, null, 12]],
                ['[\'foo,bar\', \'foo bar\']', ['foo,bar', 'foo bar']],
                // mappings
                [
                    '{foo:bar,bar:foo,false:false,null:null,integer:12}',
                    ['foo' => 'bar', 'bar' => 'foo', 'false' => false, 'null' => null, 'integer' => 12]
                ],
                [
                    '{ foo  : bar, bar : foo,  false  :   false,  null  :   null,  integer :  12  }',
                    ['foo' => 'bar', 'bar' => 'foo', 'false' => false, 'null' => null, 'integer' => 12]
                ],
                ['{foo: \'bar\', bar: \'foo: bar\'}', ['foo' => 'bar', 'bar' => 'foo: bar']],
                ['{\'foo\': \'bar\', "bar": \'foo: bar\'}', ['foo' => 'bar', 'bar' => 'foo: bar']],
                ['{\'foo\'\'\': \'bar\', "bar\"": \'foo: bar\'}', ['foo\'' => 'bar', "bar\"" => 'foo: bar']],
                ['{\'foo: \': \'bar\', "bar: ": \'foo: bar\'}', ['foo: ' => 'bar', "bar: " => 'foo: bar']],
                // nested sequences and mappings
                ['[foo, [bar, foo]]', ['foo', ['bar', 'foo']]],
                ['[foo, {bar: foo}]', ['foo', ['bar' => 'foo']]],
                ['{ foo: {bar: foo} }', ['foo' => ['bar' => 'foo']]],
                ['{ foo: [bar, foo] }', ['foo' => ['bar', 'foo']]],
                ['[  foo, [  bar, foo  ]  ]', ['foo', ['bar', 'foo']]],
                ['[{ foo: {bar: foo} }]', [['foo' => ['bar' => 'foo']]]],
                ['[foo, [bar, [foo, [bar, foo]], foo]]', ['foo', ['bar', ['foo', ['bar', 'foo']], 'foo']]],
                [
                    '[foo, {bar: foo, foo: [foo, {bar: foo}]}, [foo, {bar: foo}]]',
                    ['foo', ['bar' => 'foo', 'foo' => ['foo', ['bar' => 'foo']]], ['foo', ['bar' => 'foo']]]
                ],
                ['[foo, bar: { foo: bar }]', ['foo', '1' => ['bar' => ['foo' => 'bar']]]],
                [
                    '[foo, \'@foo.baz\', { \'%foo%\': \'foo is %foo%\', bar: \'%foo%\' }, true, \'@service_container\']',
                    ['foo', '@foo.baz', ['%foo%' => 'foo is %foo%', 'bar' => '%foo%'], true, '@service_container']
                ],
            ];
        }

        public function getTestsForParseWithMapObjects()
        {
            return [
                ['', ''],
                ['null', null],
                ['false', false],
                ['true', true],
                ['12', 12],
                ['-12', -12],
                ['"quoted string"', 'quoted string'],
                ["'quoted string'", 'quoted string'],
                ['12.30e+02', 12.30e+02],
                ['0x4D2', 0x4D2],
                ['02333', 02333],
                ['.Inf', -log(0)],
                ['-.Inf', log(0)],
                ["'686e444'", '686e444'],
                ['686e444', 646e444],
                ['123456789123456789123456789123456789', '123456789123456789123456789123456789'],
                ['"foo\r\nbar"', "foo\r\nbar"],
                ["'foo#bar'", 'foo#bar'],
                ["'foo # bar'", 'foo # bar'],
                ["'#cfcfcf'", '#cfcfcf'],
                ['::form_base.html.twig', '::form_base.html.twig'],
                ['2007-10-30', mktime(0, 0, 0, 10, 30, 2007)],
                ['2007-10-30T02:59:43Z', gmmktime(2, 59, 43, 10, 30, 2007)],
                ['2007-10-30 02:59:43 Z', gmmktime(2, 59, 43, 10, 30, 2007)],
                ['1960-10-30 02:59:43 Z', gmmktime(2, 59, 43, 10, 30, 1960)],
                ['1730-10-30T02:59:43Z', gmmktime(2, 59, 43, 10, 30, 1730)],
                ['"a \\"string\\" with \'quoted strings inside\'"', 'a "string" with \'quoted strings inside\''],
                ["'a \"string\" with ''quoted strings inside'''", 'a "string" with \'quoted strings inside\''],
                // sequences
                // urls are no key value mapping. see #3609. Valid yaml "key: value" mappings require a space after the colon
                [
                    '[foo, http://urls.are/no/mappings, false, null, 12]',
                    ['foo', 'http://urls.are/no/mappings', false, null, 12]
                ],
                ['[  foo  ,   bar , false  ,  null     ,  12  ]', ['foo', 'bar', false, null, 12]],
                ['[\'foo,bar\', \'foo bar\']', ['foo,bar', 'foo bar']],
                // mappings
                [
                    '{foo:bar,bar:foo,false:false,null:null,integer:12}',
                    (object)['foo' => 'bar', 'bar' => 'foo', 'false' => false, 'null' => null, 'integer' => 12]
                ],
                [
                    '{ foo  : bar, bar : foo,  false  :   false,  null  :   null,  integer :  12  }',
                    (object)['foo' => 'bar', 'bar' => 'foo', 'false' => false, 'null' => null, 'integer' => 12]
                ],
                ['{foo: \'bar\', bar: \'foo: bar\'}', (object)['foo' => 'bar', 'bar' => 'foo: bar']],
                ['{\'foo\': \'bar\', "bar": \'foo: bar\'}', (object)['foo' => 'bar', 'bar' => 'foo: bar']],
                ['{\'foo\'\'\': \'bar\', "bar\"": \'foo: bar\'}', (object)['foo\'' => 'bar', "bar\"" => 'foo: bar']],
                ['{\'foo: \': \'bar\', "bar: ": \'foo: bar\'}', (object)['foo: ' => 'bar', "bar: " => 'foo: bar']],
                // nested sequences and mappings
                ['[foo, [bar, foo]]', ['foo', ['bar', 'foo']]],
                ['[foo, {bar: foo}]', ['foo', (object)['bar' => 'foo']]],
                ['{ foo: {bar: foo} }', (object)['foo' => (object)['bar' => 'foo']]],
                ['{ foo: [bar, foo] }', (object)['foo' => ['bar', 'foo']]],
                ['[  foo, [  bar, foo  ]  ]', ['foo', ['bar', 'foo']]],
                ['[{ foo: {bar: foo} }]', [(object)['foo' => (object)['bar' => 'foo']]]],
                ['[foo, [bar, [foo, [bar, foo]], foo]]', ['foo', ['bar', ['foo', ['bar', 'foo']], 'foo']]],
                [
                    '[foo, {bar: foo, foo: [foo, {bar: foo}]}, [foo, {bar: foo}]]',
                    [
                        'foo',
                        (object)['bar' => 'foo', 'foo' => ['foo', (object)['bar' => 'foo']]],
                        ['foo', (object)['bar' => 'foo']]
                    ]
                ],
                ['[foo, bar: { foo: bar }]', ['foo', '1' => (object)['bar' => (object)['foo' => 'bar']]]],
                [
                    '[foo, \'@foo.baz\', { \'%foo%\': \'foo is %foo%\', bar: \'%foo%\' }, true, \'@service_container\']',
                    [
                        'foo',
                        '@foo.baz',
                        (object)['%foo%' => 'foo is %foo%', 'bar' => '%foo%'],
                        true,
                        '@service_container'
                    ]
                ],
                ['{}', new \stdClass()],
                ['{ foo  : bar, bar : {}  }', (object)['foo' => 'bar', 'bar' => new \stdClass()]],
                ['{ foo  : [], bar : {}  }', (object)['foo' => [], 'bar' => new \stdClass()]],
                ['{foo: \'bar\', bar: {} }', (object)['foo' => 'bar', 'bar' => new \stdClass()]],
                ['{\'foo\': \'bar\', "bar": {}}', (object)['foo' => 'bar', 'bar' => new \stdClass()]],
                ['{\'foo\': \'bar\', "bar": \'{}\'}', (object)['foo' => 'bar', 'bar' => '{}']],
                ['[foo, [{}, {}]]', ['foo', [new \stdClass(), new \stdClass()]]],
                ['[foo, [[], {}]]', ['foo', [[], new \stdClass()]]],
                ['[foo, [[{}, {}], {}]]', ['foo', [[new \stdClass(), new \stdClass()], new \stdClass()]]],
                ['[foo, {bar: {}}]', ['foo', '1' => (object)['bar' => new \stdClass()]]],
            ];
        }

        public function getTestsForDump()
        {
            return [
                ['null', null],
                ['false', false],
                ['true', true],
                ['12', 12],
                ["'quoted string'", 'quoted string'],
                ['!!float 1230', 12.30e+02],
                ['1234', 0x4D2],
                ['1243', 02333],
                ['.Inf', -log(0)],
                ['-.Inf', log(0)],
                ["'686e444'", '686e444'],
                ['"foo\r\nbar"', "foo\r\nbar"],
                ["'foo#bar'", 'foo#bar'],
                ["'foo # bar'", 'foo # bar'],
                ["'#cfcfcf'", '#cfcfcf'],
                ["'a \"string\" with ''quoted strings inside'''", 'a "string" with \'quoted strings inside\''],
                ["'-dash'", '-dash'],
                ["'-'", '-'],
                // Pre-YAML-1.2 booleans
                ["'y'", 'y'],
                ["'n'", 'n'],
                ["'yes'", 'yes'],
                ["'no'", 'no'],
                ["'on'", 'on'],
                ["'off'", 'off'],
                // sequences
                ['[foo, bar, false, null, 12]', ['foo', 'bar', false, null, 12]],
                ['[\'foo,bar\', \'foo bar\']', ['foo,bar', 'foo bar']],
                // mappings
                [
                    '{ foo: bar, bar: foo, \'false\': false, \'null\': null, integer: 12 }',
                    ['foo' => 'bar', 'bar' => 'foo', 'false' => false, 'null' => null, 'integer' => 12]
                ],
                ['{ foo: bar, bar: \'foo: bar\' }', ['foo' => 'bar', 'bar' => 'foo: bar']],
                // nested sequences and mappings
                ['[foo, [bar, foo]]', ['foo', ['bar', 'foo']]],
                ['[foo, [bar, [foo, [bar, foo]], foo]]', ['foo', ['bar', ['foo', ['bar', 'foo']], 'foo']]],
                ['{ foo: { bar: foo } }', ['foo' => ['bar' => 'foo']]],
                ['[foo, { bar: foo }]', ['foo', ['bar' => 'foo']]],
                [
                    '[foo, { bar: foo, foo: [foo, { bar: foo }] }, [foo, { bar: foo }]]',
                    ['foo', ['bar' => 'foo', 'foo' => ['foo', ['bar' => 'foo']]], ['foo', ['bar' => 'foo']]]
                ],
                [
                    '[foo, \'@foo.baz\', { \'%foo%\': \'foo is %foo%\', bar: \'%foo%\' }, true, \'@service_container\']',
                    ['foo', '@foo.baz', ['%foo%' => 'foo is %foo%', 'bar' => '%foo%'], true, '@service_container']
                ],
            ];
        }
    }
