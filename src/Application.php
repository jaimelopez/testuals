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

use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\Console\Input\InputInterface;

define('APPLICATION_NAME', 'Testuals');
define('APPLICATION_VERSION', '0.0.1-beta');

class Application extends BaseApplication
{
    const NAME = APPLICATION_NAME;
    const VERSION = APPLICATION_VERSION;

    /**
     * @param InputInterface $input
     * @return string
     */
    protected function getCommandName(InputInterface $input)
    {
        return self::NAME;
    }

    /**
     * @return array|\Symfony\Component\Console\Command\Command[]
     */
    protected function getDefaultCommands()
    {
        $defaultCommands = parent::getDefaultCommands();
        $defaultCommands[] = new Command();

        return $defaultCommands;
    }

    /**
     * @return \Symfony\Component\Console\Input\InputDefinition
     */
    public function getDefinition()
    {
        $inputDefinition = parent::getDefinition();
        $inputDefinition->setArguments();

        return $inputDefinition;
    }
}