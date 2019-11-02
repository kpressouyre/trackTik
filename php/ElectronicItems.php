<?php
require_once('ElectronicItem.php');
class ElectronicItems
{   
    /**
    * @var array
    */
    private $items = array();

    public function __construct(array $item = [])
    {
        $this->items = $items;
    }
    
    /**
    * Returns the items depending on the sorting type requested
    *
    * @return array
    */
    public function getSortedItems(string $type = ElectronicItem::ALL_ITEMS)
    {
        $sorted = array();
        foreach ($this->items as $item)
        {
            if($item->isType($type))
            {
                $sorted[] = $item;
            }
        }

        $arrayCount = count($sorted);
        for($i = 0; $i < $arrayCount; $i++)
        {
            for($j = 0; $j < $arrayCount - 1; $j++)
            {
                if($sorted[$j]->getPrice() * 100 > $sorted[$j+1]->getPrice() * 100)
                {
                    $sorted[$j] = [$sorted[$j+1], $sorted[$j+1] = $sorted[$j]][0]; 
                }
            }
        }

        return $sorted;
    }

    /**
    * Return an array of item selected 
    *
    * @param string $type
    * @return array 
    */
    public function getItemsByType($type)
    {
        if (in_array($type, ElectronicItem::getTypes()))
        {
            $callback = function($item) use ($type)
            {
                return $item->getType() == $type;
            };

            return array_filter($this->items, $callback);
        }

        return false;
    }


    /**
    * add an ElectonicItem to items array
    *
    * @param ElectronicItem $item
    */
    public function addItem(ElectronicItem $item)
    {
        $this->items[] = $item;
    }
    
}