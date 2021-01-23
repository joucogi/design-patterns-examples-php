<?php

/**
 * The COMPOSITE PATTERN allows you to compose objects into tree structures
 * to represent part-whole hierarchies. Composite lets clients treat individual
 * objects and compositions of objects uniformly.
 */

abstract class MenuComponent {
    public function add(MenuComponent $component): void { throw new Exception('Unsupported operation'); }

    public function remove(MenuComponent $component): void { throw new Exception('Unsupported operation'); }

    public function getChild(int $position): MenuComponent { throw new Exception('Unsupported operation'); }

    public function getName(): string { throw new Exception('Unsupported operation'); }

    public function getDescription(): string { throw new Exception('Unsupported operation'); }

    public function getPrice(): float { throw new Exception('Unsupported operation'); }

    public function isVegetarian(): bool { throw new Exception('Unsupported operation'); }

    public function print(): void { throw new Exception('Unsupported operation'); }
}

final class MenuItem extends MenuComponent {

    public function __construct(
        private string $name,
        private string $description,
        private bool $vegetarian,
        private float $price
    ) {
    }

    public function getName(): string { return $this->name; }

    public function getDescription(): string { return $this->description; }

    public function getPrice(): float { return $this->price; }

    public function isVegetarian(): bool { return $this->vegetarian; }

    public function print(): void {
        $vegetarian = $this->isVegetarian() ? ' (v)' : '';
        echo " {$this->getName()}{$vegetarian}, {$this->getPrice()}\n     -- {$this->getDescription()}\n\n";
    }
}

final class Menu extends MenuComponent {
    private array  $menuComponents = [];
    private string $name;
    private string $description;

    public function __construct(string $name, string $description) {
        $this->name        = $name;
        $this->description = $description;
    }

    public function add(MenuComponent $component): void { $this->menuComponents[] = $component; }

    public function remove(MenuComponent $component): void {
        $this->menuComponents =
            array_filter($this->menuComponents, fn(MenuComponent $item) => $item !== $component);
    }

    public function getChild(int $position): MenuComponent { return $this->menuComponents[$position]; }

    public function getName(): string { return $this->name; }

    public function getDescription(): string { return $this->description; }

    public function print(): void {
        echo "\n{$this->getName()}, {$this->getDescription()}\n--------------------------\n";
        foreach ($this->menuComponents as $component) {
            $component->print();
        }
    }
}

final class Waitress {
    public function __construct(private MenuComponent $allMenus) { }
    public function printMenu(): void { $this->allMenus->print(); }
}

/**
 * MAIN
 */

$pancakeMenu = new Menu('PANCAKE HOUSE MENU', 'Breakfast');
$dinerMenu   = new Menu('DINER MENU', 'Lunch');
$cafeMenu    = new Menu('CAFE MENU', 'Dinner');
$dessertMenu = new Menu('DESSERT MENU', 'Dessert of course!');
$allMenus    = new Menu('ALL MENUS', 'All menus combined');

$allMenus->add($pancakeMenu);
$allMenus->add($dinerMenu);
$allMenus->add($cafeMenu);

// Add menu items
$pancakeMenu->add(new MenuItem(
    'K&B Pancake Breakfast',
    'Pancake with scrambled eggs, and toast',
    true,
    2.99
));
$pancakeMenu->add(new MenuItem(
    'Regular Pancake Breakfast',
    'Pancake with scrambled eggs, sausage',
    false,
    2.99
));

$dinerMenu->add(new MenuItem(
    'Pasta',
    'Spaaghetti with Marinara Sauce, and a slice of sourdough bread',
    true,
    3.89
));
$dinerMenu->add($dessertMenu);

$dessertMenu->add(new MenuItem(
    'Apple Pie',
    'Apple pie with a flakey crust, topped with vanilla icecream',
    true,
    1.59
));

$burrito = new MenuItem(
    'Burrito',
    'A large burrito, with whole pinto beans, salsa, guacamole',
    true,
    4.29
);
$cafeMenu->add($burrito);
//$cafeMenu->remove($burrito);

$waitress = new Waitress($allMenus);

$waitress->printMenu();