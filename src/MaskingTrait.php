<?php

declare(strict_types=1);

namespace ConfigOne\MonologMaskingFormatter;

trait MaskingTrait
{
    /**
     * @var string
     */
    private $mask = '*****';

    /**
     * @var array
     */
    private $maskedFields;

    /**
     * Indicate which keys the formatter should recursively search for and mask.
     * @param array $fields an array of keys (strings) whose values to mask
     */
    public function setMaskedFields(array $fields) {
        $this->maskedFields = $fields;
    }

    public function getMask(): string
    {
        return $this->mask;
    }

    /**
     * Set the mask string to use in log files
     * @param string $mask the mask to use to replace sensitive strings
     */
    public function setMask(string $mask) {
        $this->mask = $mask;
    }

    protected function maskRecord(array $record) {

        foreach ($record as $key => &$value) {
            if (is_array($value)) {
                $value = $this->maskRecord($value);
            } elseif ($value instanceof \JsonSerializable) {
                $value = $this->maskRecord($value->jsonSerialize());
            } elseif ($this->shouldMask($key)) {
                $value = $this->mask;
            }
        }

        return $record;
    }

    private function shouldMask($key): bool
    {
        return in_array($key, $this->maskedFields, true);
    }
}