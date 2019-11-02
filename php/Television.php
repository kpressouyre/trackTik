<?php
class Television extends ElectronicItem
{
    const MAX_EXTRA = -1;

    public function __construct()
    {
        $this->setMaxExtra(self::MAX_EXTRA);
    }
}