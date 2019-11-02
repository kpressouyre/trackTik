<?php
class Microwave extends ElectronicItem
{
    const MAX_EXTRA = 0;

    public function __construct()
    {
        $this->setMaxExtra(self::MAX_EXTRA);
    }
}