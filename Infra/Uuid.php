<?php

namespace Infra;

use Ramsey\Uuid\Codec\CodecInterface;
use Ramsey\Uuid\Converter\NumberConverterInterface;
use Ramsey\Uuid\Converter\TimeConverterInterface;
use Ramsey\Uuid\Rfc4122\FieldsInterface as Rfc4122FieldsInterface;

class Uuid extends \Ramsey\Uuid\Uuid
{
    public function __construct(Rfc4122FieldsInterface $fields, NumberConverterInterface $numberConverter, CodecInterface $codec, TimeConverterInterface $timeConverter)
    {
        parent::__construct($fields, $numberConverter, $codec, $timeConverter);
    }

    public function toString(): string
    {
        return parent::toString();
    }
}