<?php
/*
 * This file is part of Testuals.
 *
 * (c) Jaime Lopez <jeims.lopez@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Santa\Testuals;

use Santa\Testuals\Test\Validation;
use Symfony\Component\Finder\Finder;

class Command
{
    const TESTS_FOLDER = __DIR__ . '/../tests/';
    const TESTS_EXTENSION = 'test';

    public function run()
    {
        $validation = new Validation();
        $validation->setMethod('methodToTest')
            ->setExpectations([
                new Validation\Expectation()
            ])
            ->setArguments(['tessst']);

        $test = new Test();
        $test->setClassname('ToTest\ServiceToTest')
            ->setDependencies([
                ['hola']
            ])
            ->setValidations([$validation])
            ->execute();

        /*
        foreach ($this->retrieveTests() as $testFile) {
            $test = new Test($testFile);
        }
        */
    }

    /**
     * @return string
     */
    private function getTestsFolder()
    {
        return realpath(self::TESTS_FOLDER);
    }

    /***
     * @return string
     */
    private function getTestsExtension()
    {
        return self::TESTS_EXTENSION;
    }

    /**
     * @return Finder|\Symfony\Component\Finder\SplFileInfo[]
     */
    private function retrieveTests()
    {
        $folder = $this->getTestsFolder();
        $pattern = '*' . $this->getTestsExtension();

        $finder = new Finder();

        return $finder->files()
            ->name($pattern)
            ->in($folder);
    }
}