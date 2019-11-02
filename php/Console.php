<?php
class Console extends ElectronicItem
{
    const MAX_EXTRA = 4;

    public function __construct()
    {
        $this->setMaxExtra(self::MAX_EXTRA);
    }
}