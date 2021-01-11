<?php

/** The ITERATOR PATTERN provides a way to access the elements
 * of an aggregate object sequentially without exposing its
 * underlying representation.
 */
class PancakeHouseMenu {
    private array $menuItems;

    public function __construct() {
        $this->menuItems[] = new Item('Spaguettis napolitana', 10.5);
        $this->menuItems[] = new Item('Cheese burguer', 8.5);
        $this->menuItems[] = new Item('Orange juice', 5);
    }

    public function getItem(int $position): ?Item {
        if (!isset($this->menuItems[$position])) {
            return null;
        }

        return $this->menuItems[$position];
    }

    public function createItemsIterator(): Iterator { return new PancakeHouseMenuIterator($this); }
}

class PancakeHouseMenuIterator implements Iterator {

    private PancakeHouseMenu $items;
    private int $position;

    public function __construct(PancakeHouseMenu $items) {
        $this->items = $items;
        $this->position = 0;
    }
    public function current(): Item { return $this->items->getItem($this->position); }
    public function next() { $this->position++; }
    public function key(): int { return $this->position; }
    public function valid(): bool { return null !== $this->items->getItem($this->position); }
    public function rewind() { $this->position = 0; }
}

class DinnerMenu {
    private array $dishes;

    public function __construct() {
        $this->dishes[] = new Item('Fish Soup', 7);
        $this->dishes[] = new Item('Omelette', 5);
        $this->dishes[] = new Item('Fruit', 5);
    }

    public function getDish(int $position): ?Item {
        if (!isset($this->dishes[$position])) {
            return null;
        }

        return $this->dishes[$position];
    }

    public function createDishesIterator(): Iterator { return new DinnerMenuIterator($this); }
}

class DinnerMenuIterator implements Iterator {

    private DinnerMenu $items;
    private int $position;

    public function __construct(DinnerMenu $items) {
        $this->items = $items;
        $this->position = 0;
    }
    public function current(): Item { return $this->items->getDish($this->position); }
    public function next() { $this->position++; }
    public function key(): int { return $this->position; }
    public function valid(): bool { return null !== $this->items->getDish($this->position); }
    public function rewind() { $this->position = 0; }
}

class Item {
    private string $name;
    private float $amount;

    public function __construct(string $name, float $amount) {
        $this->name   = $name;
        $this->amount = $amount;
    }

    public function __toString(): string {
        return sprintf('%s --> %.2f€', $this->name, $this->amount);
    }
}

/**
 * Helpers
 */
function showMenu($menu, $name): void {
    echo "\n\nShow $name Menu\n\n";
    foreach ($menu as $item) {
        echo $item . "\n";
    }
}

/**
 * MAIN
 */

$pancakeMenu = new PancakeHouseMenu();
$pancakeIterator = $pancakeMenu->createItemsIterator();
showMenu($pancakeIterator, 'Pancake House');

$dinnerMenu = new DinnerMenu();
$dinnerIterator = $dinnerMenu->createDishesIterator();
showMenu($dinnerIterator, 'Dinner');