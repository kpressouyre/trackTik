<?php
require_once('ElectronicItems.php');
require_once('ElectronicItem.php');

$items = new ElectronicItems();
$products = ['television' => 2,
        'console' => 1,
        'microwave' => 1];

$controllerConsole = ['remoteController' => 2,
            'wiredController' => 2];
$controllerTelevisions = [['remoteController' => 2], ['remoteController' => 1]];

$json = file_get_contents('data.json');
$itemsData = json_decode($json);

foreach($products as $product => $quantity)
{
    while(0 != $quantity)
    {
        $key = rand(0, count($itemsData->$product) - 1);
        $item = ElectronicItem::makeElectronicItem($product, $itemsData->$product[$key]->name, $itemsData->$product[$key]->price);
        if(ElectronicItem::ELECTRONIC_ITEM_TELEVISION == $item->getType() && !empty($controllerTelevisions))
        {
            $controller = array_shift($controllerTelevisions);
        }
        elseif(ElectronicItem::ELECTRONIC_ITEM_CONSOLE == $item->getType() && !empty($controllerConsole))
        {
            $controller = $controllerConsole;
            $controllerConsole = [];
        }
        else
        {
            $controller = null;
        }

        if(null != $controller)
        {
            foreach($controller as $typeController => $quantityController)
            {
                while(0 != $quantityController)
                {
                    $keyController = rand(0, count($itemsData->$typeController) - 1);
                    $name = $itemsData->$typeController[$keyController]->name;
                    $price = $itemsData->$typeController[$keyController]->price;
                    $controllerItem = ElectronicItem::makeElectronicItem($typeController, $name, $price);
                    $item->addController($controllerItem);
                    $items->addItem($controllerItem);
                    unset($itemsData->$typeController[$keyController]);
                    $itemsData->$typeController = array_values($itemsData->$typeController);
                    $quantityController--;
                }
            }
        }

        $items->addItem($item);
        unset($itemsData->$product[$key]);
        $itemsData->$product = array_values($itemsData->$product);
        $quantity--;
    }
}



$html = '<html><head><title>TrackTik Pressouyre Kevin</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"></head><body>
<h2>Sort by items price</h2>
<table class="table"><thead class="thead-dark"><tr><th>Class</th><th>Name</th><th>price</th></tr></thead>';

$sortedItems = $items->getSortedItems();
$priceTotal = 0.0;
foreach($sortedItems as $item)
{
    $html .= "<tr><td>".get_class($item)."</td><td>".$item->getName()."</td><td>".$item->getPrice()."</td></tr>";
    $priceTotal += $item->getPrice();
}

$html .= "</table><br/><h2>Total: ".$priceTotal."</h2>
<br/><br/>
<h3>Hi, How much have you paid for your console and their controllers ?</h3>
<br/>";


$consoles = $items->getItemsByType(ElectronicItem::ELECTRONIC_ITEM_CONSOLE);
$html .= '<h2>Console items</h2>
<table class="table"><thead class="thead-dark"><tr><th>Class</th><th>Name</th><th>price</th></tr></thead>';
$priceConsoleControllers = 0.0;
foreach($consoles as $console)
{
    $html .= "<tr><td>".get_class($console)."</td><td>".$console->getName()."</td><td>".$console->getPrice()."</td></tr>";
    foreach($console->getControllers() as $controller)
    {
        $html .= "<tr><td>".get_class($controller)."</td><td>".$controller->getName()."</td><td>".$controller->getPrice()."</td></tr>";
    }
    $html .=  "</table><br/><h2>Total console and their controllers: ".$console->getPriceWithExtra()."</h2>";
}


echo $html;