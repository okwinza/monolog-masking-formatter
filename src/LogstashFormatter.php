<?php

declare(strict_types=1);

namespace Okw\MonologMaskingFormatter;

class LogstashFormatter extends \Monolog\Formatter\LogstashFormatter
{
    use MaskingTrait;

    public function format(array $record): string
    {
        return parent::format($this->maskRecord($record));
    }
}