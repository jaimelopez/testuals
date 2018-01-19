<?php
/*
 * This file is part of Testuals.
 *
 * (c) Jaime Lopez <jeims.lopez@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JaimeLopez\Testuals\Test;

use InvalidArgumentException;

class Validator
{
    /**
     * @param array     $data
     * @param string    $file
     */
    public function validate(array $data, $file)
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
                    sprintf('%s test parameter is missing in %s test file', $parameter, $file),
                    0
                );
            }
        }

        if (!key_exists('assertions', $data) && !key_exists('expectations', $data)) {
            throw new InvalidArgumentException(
                sprintf('Some to validate is needed in %s test file', $file),
                0
            );
        }

        foreach ($data as $parameter => $value) {
            if (!in_array($parameter, $validParameters)) {
                throw new InvalidArgumentException(sprintf(
                    'Unknown test parameter %s in test file %s', $parameter, $file
                ));
            }
        }
    }
}