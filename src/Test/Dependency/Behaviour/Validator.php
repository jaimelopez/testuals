<?php
/*
 * This file is part of Testuals.
 *
 * (c) Jaime Lopez <jeims.lopez@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace JaimeLopez\Testuals\Test\Dependency\Behaviour;

use InvalidArgumentException;

class Validator
{
    /**
     * @param array  $data
     * @param string $file
     */
    public function validate(array $data, $file)
    {
        if (!is_array($data)) {
            return;
        }

        $parameters = ['call', 'return'];

        foreach ($parameters as $parameter) {
            if (!key_exists($parameter, $data)) {
                throw new InvalidArgumentException(
                    sprintf('%s behaviour dependency parameter is missing in %s test file', $parameter, $file),
                    0
                );
            }
        }

        foreach ($data as $parameter => $value) {
            if (!in_array($parameter, $parameters)) {
                throw new InvalidArgumentException(sprintf(
                    'Unknown behaviour  dependency parameter %s in test file %s', $parameter, $file
                ));
            }
        }
    }
}