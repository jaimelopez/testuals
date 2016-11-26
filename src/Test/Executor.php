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
use Symfony\Component\Console\Output\OutputInterface;

class Executor extends PHPUnit_Framework_TestCase
{
    /** @var OutputInterface */
    private $output;

    /**
     * @param Test $test
     * @param OutputInterface $output
     * @throws Exception
     */
    public function __construct(Test $test, OutputInterface $output = null)
    {
        $this->output = $output;

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
        /**
         * TODO: Maybe change it for Instantiator Doctrine library
         *
         * $instantiator = new Instantiator();
         * $object = $instantiator->instantiate($className);
         *
         * $object->$methodName();
         */

        try {
            if ($test->isDisabled()) {
                $this->showTestResult($test, Test::DISABLED);

                return;
            }

            $className = $test->getClassName();

            $dependencies = $this->generateDependencies($test);

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

            $this->showTestResult($test, Test::PASSED);
        }
        catch (\Assert\AssertionFailedException $exception) {
            $this->showTestResult($test, Test::FAILED);
        }
        catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * @param Test $test
     * @return array|PHPUnit_Framework_MockObject_MockObject[]
     */
    private function generateDependencies(Test $test)
    {
        if (!$test->getDependencies()) {
            return [];
        }

        $dependencies = [];

        foreach ($test->getDependencies() as $dependency) {
            if ($dependency->isValue()) {
                $dependencies[] = $dependency->getValue();

                continue;
            }

            $dependencyObject  = $this->generateResolvedObject($dependency->getClassName());

            if ($dependency->getBehaviours()) {
                foreach ($dependency->getProperties() as $property => $value) {
                    $dependencyObject->$property = $this->generateResolvedObject($value);
                }
            }

            if (!$dependency->getBehaviours()) {
                $dependencies[] = $dependencyObject;

                continue;
            }

            foreach ($dependency->getBehaviours() as $behaviour) {
                $dependencyObject->method($behaviour->getCall())
                    ->willReturn($behaviour->getReturn());
            }

            $dependencies[] = $dependencyObject;
        }

        return $dependencies;
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
            $arguments[] = $this->generateResolvedObject($object);
        }

        return $arguments;
    }

    /**
     * @param mixed $object
     * @return PHPUnit_Framework_MockObject_MockObject|mixed
     */
    private function generateResolvedObject($object)
    {
        $objectAnalyzer = new ObjectAnalyzer($object);

        if ($objectAnalyzer->isPrimitive() && !$objectAnalyzer->isReference()) {
            return $object;
        }

        $className = $objectAnalyzer->isReference()
            ? $objectAnalyzer->getReference()
            : get_class($object);

        return $this->createMock($className);
    }

    /**
     * @param Test $test
     * @param      $result
     */
    private function checkAssertions(Test $test, $result)
    {
        foreach ($test->getAssertions() as $assertion) {
            $assertThat = $assertion->getThat();
            $assertValue = $assertion->getValue();

            $assert = \Assert\Assert::that($result);

            $result = !empty($assertValue)
                ? $assert->$assertThat($assertValue)
                : $assert->$assertThat();
        }
    }

    /**
     * @param Test $test
     * @param string $status
     */
    private function showTestResult(Test $test, $status)
    {
        $message = sprintf('# Executing %s test... [%s]', $test->getName(), $this->formatTestStatus($status));

        $this->show($message);
    }

    /**
     * @param string $message
     */
    private function show($message)
    {
        if (!$this->output) {
            return;
        }

        $this->output->writeln($message);
    }

    /**
     * @param $status
     * @return string
     */
    private function formatTestStatus($status)
    {
        $style = 'question';

        switch ($status) {
            case Test::FAILED:
                $style = 'error';
                break;

            case Test::PASSED:
                $style = 'info';
                break;

            case Test::DISABLED:
                $style = 'comment';
                break;
        }

        return sprintf('<%s>%s</%s>', $style, strtoupper($status), $style);
    }
}