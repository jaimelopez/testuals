<?php
/*
 * This file is part of Testuals.
 *
 * (c) Jaime Lopez <jeims.lopez@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Santa\Testuals\Test;

use BadMethodCallException;
use Exception;
use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;
use ReflectionClass;
use Santa\Testuals\ObjectAnalyzer;
use Santa\Testuals\Test;

class Executor extends PHPUnit_Framework_TestCase
{
    const RESULT_KEY = '##result##';

    /**
     * @param Test $test
     * @throws Exception
     */
    public function __construct(Test $test)
    {
        if (!$test->getClassname()) {
            throw new Exception('You must to specify the class to test');
        }

        parent::__construct();

        $this->execute($test);
    }

    /**
     * @param Test $test
     */
    private function execute(Test $test)
    {
        $className = $test->getClassName();

        $dependencies = $this->generateArguments($test->getDependencies());

        $reflecter = new ReflectionClass($className);
        $instance = $reflecter->newInstanceArgs($dependencies);

        $methodName = $test->getMethodName();
        $method = $reflecter->getMethod($methodName);
        $arguments = $this->generateArguments($test->getArguments());

        if (!$reflecter->hasMethod($methodName)) {
            throw new BadMethodCallException('Inexistent method!');
        }

        if (!$method->isPublic()) {
            throw new BadMethodCallException('Method to test should be public!');
        }

        $result = $method->invokeArgs($instance, $arguments);

        $this->checkAssertions($test, $result);

        /**
         * TODO: Maybe change it for Instantiator Doctrine library
         *
         * $instantiator = new Instantiator();
         * $object = $instantiator->instantiate($className);
         *
         * $object->$methodName();
         */
    }

    /**
     * @param array
     * @return array|PHPUnit_Framework_MockObject_MockObject[]
     */
    private function generateArguments(array $objects)
    {
        if (!$objects) {
            return [];
        }

        $arguments = [];

        foreach ($objects as $object) {
            $objectAnalyzer = new ObjectAnalyzer($object);

            if ($objectAnalyzer->isPrimitive()) {
                $arguments[] = $object;

                continue;
            }

            $objects[] = $this->createMock(get_class($object));
        }

        return $objects;
    }

    /**
     * @param Test $test
     * @param      $result
     */
    private function checkAssertions(Test $test, $result)
    {
        foreach ($test->getAssertions() as $assertion) {
            $assertion = str_replace(self::RESULT_KEY, $result, $assertion);
        }
    }
}