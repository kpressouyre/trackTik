<?php
require_once('Television.php');
require_once('Console.php');
require_once('Microwave.php');
require_once('RemoteController.php');
require_once('WiredController.php');
class ElectronicItem
{

    /**
    * @var float
    */
    protected $price;

    /**
    * @var string
    */
    protected $type;

    /**
    * @var array
    */
    protected $controllers = [];

    /**
    * @var int
    */
    protected $maxExtras;

    /**
    * @var string
    */
    protected $name;

    const ELECTRONIC_ITEM_TELEVISION = 'television';
    const ELECTRONIC_ITEM_CONSOLE = 'console';
    const ELECTRONIC_ITEM_MICROWAVE = 'microwave';
    const ELECTRONIC_ITEM_WIRED_CONTROLLER = 'wiredController';
    const ELECTRONIC_ITEM_REMOTE_CONTROLLER = 'remoteController';
    const ALL_ITEMS = 'ALL';

    /**
    * @var array
    */
    private static $types = array(self::ELECTRONIC_ITEM_CONSOLE,
    self::ELECTRONIC_ITEM_MICROWAVE, self::ELECTRONIC_ITEM_TELEVISION, self::ELECTRONIC_ITEM_WIRED_CONTROLLER,
    self::ELECTRONIC_ITEM_REMOTE_CONTROLLER);

    public function __construct(string $type = null, string $name = '', float $price = 0.0)
    {
        $this->setType($type);
        $this->setName($name);
        $this->setPrice($price);
    }

    /////////////////////////////////
    ///////// BEGIN GETTER /////////
    /////////////////////////////////
    public function getPrice(): float
    {
        return $this->price;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getControllers(): array
    {
        return $this->controllers;
    }

    public function getMaxExtras(): int
    {
        return $this->maxExtras;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPriceWithExtra()
    {
        $price = $this->getPrice();
        foreach($this->getControllers() as $controller)
        {
            $price += $controller->getPrice();
        }
        
        return $price;
    }

    public static function getTypes(): array
    {
        return self::$types;
    }
    /////////////////////////////////
    ////////// END GETTER ///////////
    /////////////////////////////////

    /////////////////////////////////
    ///////// BEGIN SETTER //////////
    /////////////////////////////////
    public function setPrice(float $price)
    {
        $this->price = $price;
    }

    public function setType(string $type)
    {
        $this->type = $type;
    }

    public function setControllers(array $controllers)
    {
        $this->controllers = $controllers;
    }

    public function setMaxExtra(int $maxExtras)
    {
        $this->maxExtras = $maxExtras;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }
    /////////////////////////////////
    ////////// END SETTER ///////////
    /////////////////////////////////

    public function addController($controller)
    {
        if($this->getMaxExtras() == - 1 || $this->getMaxExtras() > count($this->getControllers()))
        {
            $this->controllers[] = $controller;
        }
    }

    /**
    * @param string
    *
    * @return boolean
    */
    public function isType($type)
    {
        return $type == $this->getType() || $type == self::ALL_ITEMS;
    }

    /**
    * @param string
    * @param string
    * @param float
    * @param boolean
    *
    * @return an object of the type, default ElectronicItem object
    */
    public static function makeElectronicItem(string $type = null, string $name = '', float $price = 0.0, $keepData = true)
    {
        $object = new ElectronicItem($type, $name, $price);
        if(in_array($object->type, self::$types))
        {
            $class =  ucfirst($object->type);
            $objectReturn = new $class();
            if($keepData)
            {
                 $object->moveSelfDataToObject($objectReturn);
            }
        }

        return isset($objectReturn) ? $objectReturn : $object;
    }

    /**
    * @param ElectronicItem
    *
    */
    private function moveSelfDataToObject($object)
    {
        $object->setPrice($this->getPrice());
        $object->setName($this->getName());
        $object->setType($this->getType());
    }

}