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

use InvalidArgumentException;
use Santa\Testuals\Test;
use Symfony\Component\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;

class Parser
{
    /** @var string */
    private $file;

    /**
     * @param string $file
     */
    public function __construct($file)
    {
        $this->file = $file;
    }

    /**
     * @return Test
     */
    public function get()
    {
        $parser = new Yaml\Parser();
        $dataParsed = null;

        try {
            $dataParsed = $parser->parse(file_get_contents($this->file));

            if (!is_array($dataParsed)) {
                throw new InvalidArgumentException('Invalid format test!');
            }
        }
        catch (ParseException $e) {
            throw new InvalidArgumentException(
                sprintf('The file %s does not contain valid test', $this->file),
                0,
                $e
            );
        }

        return $this->parse($dataParsed);
    }

    /**
     * @param array $dataParsed
     * @return Test
     */
    private function parse(array $dataParsed)
    {
        $this->validateTestData($dataParsed);

        $test = new Test();

        foreach ($dataParsed as $property => $value) {
            $test = $this->fillTestProperty($test, $property, $value);
        }

        return $test;
    }

    /**
     * @param array $data
     */
    private function validateTestData(array $data)
    {
        $requiredParameters = ['name', 'class', 'method'];

        $validParameters = array_merge([
            'dependencies',
            'arguments',
            'assertions',
            'expectations',
            'disabled'
        ], $requiredParameters);

        foreach ($requiredParameters as $parameter) {
            if (!key_exists($parameter, $data)) {
                throw new InvalidArgumentException(
                    sprintf('%s test parameter is missing in %s test file', $parameter, $this->file),
                    0
                );
            }
        }

        if (!key_exists('assertions', $data) && !key_exists('expectations', $data)) {
            throw new InvalidArgumentException(
                sprintf('Some to validate is needed in %s test file', $this->file),
                0
            );
        }

        foreach ($data as $parameter => $value) {
            if (!in_array($parameter, $validParameters)) {
                throw new InvalidArgumentException(sprintf(
                    'Unknown test parameter %s in test file %s', $parameter, $this->file
                ));
            }
        }
    }

    /**
     * @param Test $test
     * @param      $property
     * @param      $value
     * @return Test
     */
    private function fillTestProperty(Test $test, $property, $value)
    {
        switch ($property) {
            case 'name':
                $test->setName($value);
                break;

            case 'class':
                $test->setClassname($value);
                break;

            case 'dependencies':
                $test->setDependencies($this->generateDependencies($value));
                break;

            case 'method':
                $test->setMethodName($value);
                break;

            case 'arguments':
                $test->setArguments($value);
                break;

            case 'assertions':
                $test->setAssertions($this->generateAssertions($value));
                break;

            case 'expectations':
                $test->setExpectations($this->generateExpectations($value));
                break;

            case 'disabled':
                $test->setDisabled(boolval($value));
                break;
        }

        return $test;
    }

    /**
     * @param array $items
     * @return Dependency[]
     */
    private function generateDependencies(array $items)
    {
        $parser = new Dependency\Parser($this->file, $items);

        return $parser->get();
    }

    /**
     * @param array $items
     * @return Assertion[]
     */
    private function generateAssertions(array $items)
    {
        $parser = new Assertion\Parser($this->file, $items);

        return $parser->get();
    }

    /**
     * @param array $items
     * @return Expectation[]
     */
    private function generateExpectations(array $items)
    {
        $parser = new Expectation\Parser($this->file, $items);

        return $parser->get();
    }
}