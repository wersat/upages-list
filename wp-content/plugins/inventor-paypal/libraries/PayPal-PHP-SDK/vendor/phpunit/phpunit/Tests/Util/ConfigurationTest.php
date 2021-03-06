<?php
    /**
     * PHPUnit
     * Copyright (c) 2001-2014, Sebastian Bergmann <sebastian@phpunit.de>.
     * All rights reserved.
     * Redistribution and use in source and binary forms, with or without
     * modification, are permitted provided that the following conditions
     * are met:
     *   * Redistributions of source code must retain the above copyright
     *     notice, this list of conditions and the following disclaimer.
     *   * Redistributions in binary form must reproduce the above copyright
     *     notice, this list of conditions and the following disclaimer in
     *     the documentation and/or other materials provided with the
     *     distribution.
     *   * Neither the name of Sebastian Bergmann nor the names of his
     *     contributors may be used to endorse or promote products derived
     *     from this software without specific prior written permission.
     * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
     * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
     * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
     * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
     * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
     * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
     * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
     * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
     * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
     * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
     * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
     * POSSIBILITY OF SUCH DAMAGE.
     * @package    PHPUnit
     * @author     Sebastian Bergmann <sebastian@phpunit.de>
     * @copyright  2001-2014 Sebastian Bergmann <sebastian@phpunit.de>
     * @license    http://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
     * @link       http://www.phpunit.de/
     * @since      File available since Release 3.3.0
     */

    /**
     * @package    PHPUnit
     * @author     Sebastian Bergmann <sebastian@phpunit.de>
     * @copyright  2001-2014 Sebastian Bergmann <sebastian@phpunit.de>
     * @license    http://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
     * @link       http://www.phpunit.de/
     * @since      Class available since Release 3.3.0
     */
    class Util_ConfigurationTest extends PHPUnit_Framework_TestCase
    {
        protected $configuration;

        protected function setUp()
        {
            $this->configuration
                = PHPUnit_Util_Configuration::getInstance(dirname(__DIR__) . DIRECTORY_SEPARATOR . '_files' . DIRECTORY_SEPARATOR . 'configuration.xml');
        }

        /**
         * @expectedException PHPUnit_Framework_Exception
         */
        public function testExceptionIsThrownForNotExistingConfigurationFile()
        {
            PHPUnit_Util_Configuration::getInstance('not_existing_file.xml');
        }

        public function testFilterConfigurationIsReadCorrectly()
        {
            $this->assertEquals([
                'blacklist' => [
                    'include' => [
                        'directory' => [
                            0 => [
                                'path'   => '/path/to/files',
                                'prefix' => '',
                                'suffix' => '.php',
                                'group'  => 'DEFAULT'
                            ],
                        ],
                        'file'      => [
                            0 => '/path/to/file',
                        ],
                    ],
                    'exclude' => [
                        'directory' => [
                            0 => [
                                'path'   => '/path/to/files',
                                'prefix' => '',
                                'suffix' => '.php',
                                'group'  => 'DEFAULT'
                            ],
                        ],
                        'file'      => [
                            0 => '/path/to/file',
                        ],
                    ],
                ],
                'whitelist' => [
                    'addUncoveredFilesFromWhitelist'     => true,
                    'processUncoveredFilesFromWhitelist' => false,
                    'include'                            => [
                        'directory' => [
                            0 => [
                                'path'   => '/path/to/files',
                                'prefix' => '',
                                'suffix' => '.php',
                                'group'  => 'DEFAULT'
                            ],
                        ],
                        'file'      => [
                            0 => '/path/to/file',
                        ],
                    ],
                    'exclude'                            => [
                        'directory' => [
                            0 => [
                                'path'   => '/path/to/files',
                                'prefix' => '',
                                'suffix' => '.php',
                                'group'  => 'DEFAULT'
                            ],
                        ],
                        'file'      => [
                            0 => '/path/to/file',
                        ],
                    ],
                ],
            ], $this->configuration->getFilterConfiguration());
        }

        public function testGroupConfigurationIsReadCorrectly()
        {
            $this->assertEquals([
                'include' => [
                    0 => 'name',
                ],
                'exclude' => [
                    0 => 'name',
                ],
            ], $this->configuration->getGroupConfiguration());
        }

        public function testListenerConfigurationIsReadCorrectly()
        {
            $dir         = __DIR__;
            $includePath = ini_get('include_path');
            ini_set('include_path', $dir . PATH_SEPARATOR . $includePath);
            $this->assertEquals([
                0 => [
                    'class'     => 'MyListener',
                    'file'      => '/optional/path/to/MyListener.php',
                    'arguments' => [
                        0 => [
                            0 => 'Sebastian',
                        ],
                        1 => 22,
                        2 => 'April',
                        3 => 19.78,
                        4 => null,
                        5 => new stdClass,
                        6 => dirname(__DIR__) . DIRECTORY_SEPARATOR . '_files' . DIRECTORY_SEPARATOR . 'MyTestFile.php',
                        7 => dirname(__DIR__) . DIRECTORY_SEPARATOR . '_files' . DIRECTORY_SEPARATOR . 'MyRelativePath',
                    ],
                ],
                [
                    'class'     => 'IncludePathListener',
                    'file'      => __FILE__,
                    'arguments' => []
                ],
                [
                    'class'     => 'CompactArgumentsListener',
                    'file'      => '/CompactArgumentsListener.php',
                    'arguments' => [
                        0 => 42
                    ],
                ],
            ], $this->configuration->getListenerConfiguration());
            ini_set('include_path', $includePath);
        }

        public function testLoggingConfigurationIsReadCorrectly()
        {
            $this->assertEquals([
                'charset'              => 'UTF-8',
                'lowUpperBound'        => '35',
                'highLowerBound'       => '70',
                'highlight'            => false,
                'coverage-html'        => '/tmp/report',
                'coverage-clover'      => '/tmp/clover.xml',
                'json'                 => '/tmp/logfile.json',
                'plain'                => '/tmp/logfile.txt',
                'tap'                  => '/tmp/logfile.tap',
                'logIncompleteSkipped' => false,
                'junit'                => '/tmp/logfile.xml',
                'testdox-html'         => '/tmp/testdox.html',
                'testdox-text'         => '/tmp/testdox.txt',
            ], $this->configuration->getLoggingConfiguration());
        }

        public function testPHPConfigurationIsReadCorrectly()
        {
            $this->assertEquals([
                'include_path' => [
                    dirname(__DIR__) . DIRECTORY_SEPARATOR . '_files' . DIRECTORY_SEPARATOR . '.',
                    '/path/to/lib'
                ],
                'ini'          => ['foo' => 'bar'],
                'const'        => ['FOO' => false, 'BAR' => true],
                'var'          => ['foo' => false],
                'env'          => ['foo' => true],
                'post'         => ['foo' => 'bar'],
                'get'          => ['foo' => 'bar'],
                'cookie'       => ['foo' => 'bar'],
                'server'       => ['foo' => 'bar'],
                'files'        => ['foo' => 'bar'],
                'request'      => ['foo' => 'bar'],
            ], $this->configuration->getPHPConfiguration());
        }

        /**
         * @backupGlobals enabled
         */
        public function testPHPConfigurationIsHandledCorrectly()
        {
            $this->configuration->handlePHPConfiguration();
            $path
                = dirname(__DIR__) . DIRECTORY_SEPARATOR . '_files' . DIRECTORY_SEPARATOR . '.' . PATH_SEPARATOR . '/path/to/lib';
            $this->assertStringStartsWith($path, ini_get('include_path'));
            $this->assertEquals(false, FOO);
            $this->assertEquals(true, BAR);
            $this->assertEquals(false, $GLOBALS['foo']);
            $this->assertEquals(true, $_ENV['foo']);
            $this->assertEquals(true, getenv('foo'));
            $this->assertEquals('bar', $_POST['foo']);
            $this->assertEquals('bar', $_GET['foo']);
            $this->assertEquals('bar', $_COOKIE['foo']);
            $this->assertEquals('bar', $_SERVER['foo']);
            $this->assertEquals('bar', $_FILES['foo']);
            $this->assertEquals('bar', $_REQUEST['foo']);
        }

        public function testPHPUnitConfigurationIsReadCorrectly()
        {
            $this->assertEquals([
                'backupGlobals'                      => true,
                'backupStaticAttributes'             => false,
                'bootstrap'                          => '/path/to/bootstrap.php',
                'cacheTokens'                        => false,
                'colors'                             => false,
                'convertErrorsToExceptions'          => true,
                'convertNoticesToExceptions'         => true,
                'convertWarningsToExceptions'        => true,
                'forceCoversAnnotation'              => false,
                'mapTestClassNameToCoveredClassName' => false,
                'printerClass'                       => 'PHPUnit_TextUI_ResultPrinter',
                'stopOnFailure'                      => false,
                'strict'                             => false,
                'testSuiteLoaderClass'               => 'PHPUnit_Runner_StandardTestSuiteLoader',
                'verbose'                            => false,
                'timeoutForSmallTests'               => 1,
                'timeoutForMediumTests'              => 10,
                'timeoutForLargeTests'               => 60
            ], $this->configuration->getPHPUnitConfiguration());
        }

        public function testSeleniumBrowserConfigurationIsReadCorrectly()
        {
            $this->assertEquals([
                0 => [
                    'name'    => 'Firefox on Linux',
                    'browser' => '*firefox /usr/lib/firefox/firefox-bin',
                    'host'    => 'my.linux.box',
                    'port'    => 4444,
                    'timeout' => 30000,
                ],
            ], $this->configuration->getSeleniumBrowserConfiguration());
        }

        public function testXincludeInConfiguration()
        {
            $configurationWithXinclude
                = PHPUnit_Util_Configuration::getInstance(dirname(__DIR__) . DIRECTORY_SEPARATOR . '_files' . DIRECTORY_SEPARATOR . 'configuration_xinclude.xml');
            $this->assertConfigurationEquals($this->configuration, $configurationWithXinclude);
        }

        /**
         * Asserts that the values in $actualConfiguration equal $expectedConfiguration.
         *
         * @param PHPUnit_Util_Configuration $expectedConfiguration
         * @param PHPUnit_Util_Configuration $actualConfiguration
         *
         * @return void
         */
        protected function assertConfigurationEquals(
            PHPUnit_Util_Configuration $expectedConfiguration,
            PHPUnit_Util_Configuration $actualConfiguration
        ) {
            $this->assertEquals($expectedConfiguration->getFilterConfiguration(),
                $actualConfiguration->getFilterConfiguration());
            $this->assertEquals($expectedConfiguration->getGroupConfiguration(),
                $actualConfiguration->getGroupConfiguration());
            $this->assertEquals($expectedConfiguration->getListenerConfiguration(),
                $actualConfiguration->getListenerConfiguration());
            $this->assertEquals($expectedConfiguration->getLoggingConfiguration(),
                $actualConfiguration->getLoggingConfiguration());
            $this->assertEquals($expectedConfiguration->getPHPConfiguration(),
                $actualConfiguration->getPHPConfiguration());
            $this->assertEquals($expectedConfiguration->getPHPUnitConfiguration(),
                $actualConfiguration->getPHPUnitConfiguration());
            $this->assertEquals($expectedConfiguration->getSeleniumBrowserConfiguration(),
                $actualConfiguration->getSeleniumBrowserConfiguration());
            $this->assertEquals($expectedConfiguration->getTestSuiteConfiguration(),
                $actualConfiguration->getTestSuiteConfiguration());
        }
    }
