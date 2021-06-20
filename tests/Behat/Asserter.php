<?php

declare(strict_types=1);

namespace App\Tests\Behat;

use Exception;

use function sprintf;

trait Asserter
{
    /**
     * @throws Exception
     */
    protected function assert(bool $test, string $message): void
    {
        if ($test === false) {
            throw new Exception($message);
        }
    }

    /**
     * @param mixed $expected
     * @param mixed $actual
     *
     * @throws Exception
     */
    protected function assertEquals($expected, $actual, ?string $message = null): void
    {
        $this->assert(
            $expected === $actual,
            $message ?: sprintf("The element '%s' is not equal to '%s'", $actual, $expected)
        );
    }

    /**
     * @param string|int $key
     * @param mixed[]    $array
     *
     * @throws Exception
     */
    protected function assertArrayHasKey($key, array $array, ?string $message = null): void
    {
        $this->assert(
            isset($array[$key]),
            $message ?: sprintf("The array has no key '%d'", $key)
        );
    }
}
