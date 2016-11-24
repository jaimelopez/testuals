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

use Doctrine\Instantiator\Instantiator;
use Exception;
use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;
use ReflectionClass;
use Santa\Testuals\Test;

class Executor extends PHPUnit_Framework_TestCase
{
    /** @var Test */
    private $test;

    /** @var PHPUnit_Framework_MockObject_MockObject[] */
    private $dependencies;

    /**
     * @param Test $test
     * @throws Exception
     */
    public function __construct(Test $test)
    {
        if (!$test->getClassname()) {
            throw new Exception('You must to specify the class to test');
        }

        if (!$test->getValidations()) {
            throw new Exception('You must to specify some validations!');
        }

        $this->test = $test;
        $this->dependencies = $this->generateDependencies($test);

        parent::__construct();

        $this->execute();
    }

    /**
     * @param Test $test
     * @return PHPUnit_Framework_MockObject_MockObject[]
     */
    private function generateDependencies(Test $test)
    {
        $dependencies = [];

        if (!$test->getDependencies()) {
            return [];
        }

        foreach ($test->getDependencies() as $dependency) {
            $dependencies[] = $this->createMock($dependency->getClassName());
        }

        return $dependencies;
    }

    private function execute()
    {
        foreach ($this->test->getValidations() as $validation) {
            $this->validate($validation);
        }
    }

    /**
     * @param Validation $validation
     */
    private function validate(Validation $validation)
    {
        $className = $this->test->getClassname();

        $dependencies = $this->dependencies;

        $reflecter = new ReflectionClass($className);
        $instance = $reflecter->newInstanceArgs($dependencies);

        $methodName = $validation->getMethod();
        $method = $reflecter->getMethod($methodName);
        $arguments = $this->generateArguments($validation);

        if (!$reflecter->hasMethod($methodName)) {
            throw new Exception('Inexistent method!');
        }

        if (!$method->isPublic()) {
            throw new Exception('Method to test should be public!');
        }

        $method->invokeArgs($instance, $arguments);

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
     * @param Validation $validation
     * @return array
     */
    private function generateArguments(Validation $validation)
    {
        if (!$validation->getArguments()) {
            return [];
        }

        $arguments = [];

        foreach ($validation->getArguments() as $argument) {
            $arguments[] = $argument->getValue();
        }

        return $arguments;
    }
}