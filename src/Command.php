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

use Santa\Testuals\Test\Executor;
use Santa\Testuals\Test\Parser;
use Symfony\Component\Console\Command\Command as CommandBase;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;

class Command extends CommandBase
{
    const DEFAULT_TESTS_FOLDER = __DIR__ . '/../tests/';
    const DEFAULT_TESTS_EXTENSION = 'test';

    /** @var string */
    private $path;

    /** @var string */
    private $extension;

    protected function configure()
    {
        $this
            ->setName('Testuals')
            ->addOption('path', 'p', InputOption::VALUE_OPTIONAL, 'Path for tests', self::DEFAULT_TESTS_FOLDER)
            ->addOption('extension', 'e', InputOption::VALUE_OPTIONAL, 'Extension', self::DEFAULT_TESTS_EXTENSION);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->setOptions($input);

        foreach ($this->retrieveTests() as $test) {
            new Executor($test);
        }
    }

    /**
     * @param InputInterface $input
     */
    private function setOptions(InputInterface $input)
    {
        $this->path = $input->getOption('path');
        $this->extension = $input->getOption('extension');
    }

    /**
     * @return string
     */
    private function getTestsFolder()
    {
        return realpath(self::DEFAULT_TESTS_FOLDER);
    }

    /***
     * @return string
     */
    private function getTestsExtension()
    {
        return self::DEFAULT_TESTS_EXTENSION;
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

            $tests[] = $parser->get();
        }

        return $tests;
    }
}