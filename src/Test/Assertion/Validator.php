<?php
/*
 * This file is part of Testuals.
 *
 * (c) Jaime Lopez <jeims.lopez@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JaimeLopez\Testuals\Test\Assertion;

use InvalidArgumentException;

class Validator
{
    /**
     * @param array  $data
     * @param string $file
     */
    public function validate(array $data, $file)
    {
        $requiredParameters = ['that'];

        $validParameters = array_merge([
            'value'
        ], $requiredParameters);

        foreach ($requiredParameters as $parameter) {
            if (!key_exists($parameter, $data)) {
                throw new InvalidArgumentException(
                    sprintf('%s assertion parameter is missing in %s test file', $parameter, $file),
                    0
                );
            }
        }

        foreach ($data as $parameter => $value) {
            if (!in_array($parameter, $validParameters)) {
                throw new InvalidArgumentException(sprintf(
                    'Unknown assertion parameter %s in test file %s', $parameter, $file
                ));
            }
        }
    }
}