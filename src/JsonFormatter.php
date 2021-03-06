<?php

declare(strict_types=1);

namespace Okw\MonologMaskingFormatter;

class JsonFormatter extends \Monolog\Formatter\JsonFormatter
{
    use MaskingTrait;

    public function format(array $record): string
    {
        return parent::format($this->maskRecord($record));
    }
}