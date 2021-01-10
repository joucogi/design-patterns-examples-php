<?php

/*** DECORATOR PATTERN attaches additional responsibilities to an object dynamically.
 *  Decorators provide a flexible alternative to subclassing for extending functionality.
 */

interface Coffee {
    public function name(): String;
    public function cost(): float;
}

/**
 * Types of Coffee
 */
class BlackCoffee implements Coffee {

    public function name(): string {
        return 'Black Coffee';
    }

    public function cost(): float {
        return 2.0;
    }
}

class Espresso implements Coffee {

    public function name(): string {
        return 'Espresso';
    }

    public function cost(): float {
        return 1.5;
    }
}

/**
 * Decorators for Coffee
 */
abstract class CoffeeDecorator implements Coffee {
    private Coffee $coffee;
    protected string $name = '';
    protected float $price = 0;

    public function __construct(Coffee $coffee) { $this->coffee = $coffee; }

    public function name(): string {
        return "{$this->coffee->name()} with {$this->name}";
    }

    public function cost(): float {
        return $this->coffee->cost() + $this->price;
    }
}

class CoffeeWithMocha extends CoffeeDecorator {
    protected string $name = 'Mocha';
    protected float $price = 0.5;
}

class CoffeeWithSugar extends CoffeeDecorator {
    protected string $name = 'Sugar';
    protected float $price = 0.25;
}

class CoffeeWithDiscount implements Coffee {
    private Coffee $coffee;
    private int $discount;

    public function __construct(Coffee $coffee, int $discount) {
        $this->coffee = $coffee;
        $this->discount = $discount;
    }

    public function name(): string {
        return "{$this->coffee->name()} has a discount of {$this->discount}%";
    }

    public function cost(): float {
        return $this->coffee->cost() - $this->coffee->cost() * $this->discount / 100;
    }
}

/**
 * Helpers
 */
function writeOutput(Coffee $coffee): void {
    $formatedCost = number_format($coffee->cost(), 2);
    echo "- {$coffee->name()} costs {$formatedCost}€\n";
}

/**
 * MAIN
 */
$blackCoffee = new BlackCoffee();
writeOutput($blackCoffee);

$blackCoffeeWithMocha = new CoffeeWithMocha($blackCoffee);
writeOutput($blackCoffeeWithMocha);

$blackCoffeeWithDoubleMocha = new CoffeeWithMocha($blackCoffeeWithMocha);
writeOutput($blackCoffeeWithDoubleMocha);

$blackCoffeeWithDoubleMochaAndSugar = new CoffeeWithSugar($blackCoffeeWithDoubleMocha);
writeOutput($blackCoffeeWithDoubleMochaAndSugar);

$blackCoffeeWithMochaAndSugarWithDiscount = new CoffeeWithDiscount($blackCoffeeWithDoubleMochaAndSugar, 10);
writeOutput($blackCoffeeWithMochaAndSugarWithDiscount);

$espresso = new Espresso();
writeOutput($espresso);

$espressoWithMocha = new CoffeeWithMocha($espresso);
writeOutput($espressoWithMocha);

$espressoWithMochaAndSugar = new CoffeeWithSugar($espressoWithMocha);
writeOutput($espressoWithMochaAndSugar);

$espressoWithMochaAndSugarWithDiscount = new CoffeeWithDiscount($espressoWithMochaAndSugar, 20);
writeOutput($espressoWithMochaAndSugarWithDiscount);
