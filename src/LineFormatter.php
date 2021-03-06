<?php

declare(strict_types=1);

namespace Okw\MonologMaskingFormatter;

class LineFormatter extends \Monolog\Formatter\LineFormatter {

    use MaskingTrait;

    public function format(array $record): string
    {
        return parent::format($this->maskRecord($record));
    }
}