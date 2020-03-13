<?php

declare(strict_types=1);

namespace ConfigOne\MonologMaskingFormatter\Tests\Monolog;

use ConfigOne\MonologMaskingFormatter\MaskingTrait;

class TestMaskingFormatter
{
    use MaskingTrait;

    public function format(array $record)
    {
        return $this->maskRecord($record);
    }
}