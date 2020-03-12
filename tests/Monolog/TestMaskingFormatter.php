<?php

declare(strict_types=1);

namespace Okw\MonologMaskingFormatter\Tests\Monolog;

use Okw\MonologMaskingFormatter\MaskingTrait;

class TestMaskingFormatter
{
    use MaskingTrait;

    public function format(array $record)
    {
        return $this->maskRecord($record);
    }
}