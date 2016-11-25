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

use Santa\Testuals\Test\Parser;
use Symfony\Component\Finder\Finder;

class Command
{
    const TESTS_FOLDER = __DIR__ . '/../tests/';
    const TESTS_EXTENSION = 'test';

    public function run()
    {
        foreach ($this->retrieveTests() as $test) {
            $test->execute();
        }
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
     * @return Test[]:
     */
    private function retrieveTests()
    {
        $folder = $this->getTestsFolder();
        $pattern = '*' . $this->getTestsExtension();

        $finder = new Finder();

        $files = $finder->files()
            ->name($pattern)
            ->in($folder);

        $tests = [];

        foreach ($files as $file) {
            $parser = new Parser($file);

            $tests[] = $parser->getTest();
        }

        return $tests;
    }
}