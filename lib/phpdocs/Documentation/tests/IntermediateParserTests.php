<?php
if (!defined('PHPUnit_MAIN_METHOD')) {
    define('PHPUnit_MAIN_METHOD', 'IntermediateParserTests::main');
}
 
require_once 'PHPUnit/Framework.php';
require_once 'PHPUnit/TextUI/TestRunner.php';

/* You must add each method-level test suite file here */ 
require_once 'Documentation/tests/IntermediateParserAddPrivatePageTests.php';

class Documentation_tests_IntermediateParserTests
{
    public static function main()
    {
        PHPUnit_TextUI_TestRunner::run(self::suite());
    }
 
    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite('IntermediateParser Unit Test Suites');
        /* You must add each method-level test suite name here */ 
        $suite->addTestSuite('Documentation_tests_IntermediateParserAddPrivatePageTests');
        return $suite;
    }
}
 
if (PHPUnit_MAIN_METHOD == 'IntermediateParserTests::main') {
    Documentation_tests_IntermediateParserTests::main();
}
?>
