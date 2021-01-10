<?php

/*** ABSTRACT FACTORY PATTERN provides an interface for creating families of related or dependent
 *  objects without specifying their concrete classes.
 */

// Abstract Pizza Ingredient Factory
interface PizzaIngredientFactory {
    public function createDough(): Dough; // Factory method
    public function createSauce(): Sauce; // Factory method
    public function createCheese(): Cheese; // Factory method
    public function createClam(): Clams; // Factory method
}

// Ingredients interfaces
interface Dough { public function __toString(): string; }
interface Sauce { public function __toString(): string; }
interface Cheese { public function __toString(): string; }
interface Clams { public function __toString(): string; }
interface Pepperoni { public function __toString(): string; }

// Pizza Store interface
interface PizzaStore {
    public function createPizza(): void;
}

// Ingredients Implementations
class ThickCrustDough implements Dough { public function __toString(): string { return 'Thick and Crust Dough'; } }
class ThinCrustDough implements Dough { public function __toString(): string { return 'Thin and Crust Dough'; } }
class PlumTomatoSauce implements Sauce { public function __toString(): string { return 'Plum Tomato Sauce'; } }
class MarinaraSauce implements Sauce { public function __toString(): string { return 'Marinara Sauce'; } }
class MozzarellaCheese implements Cheese { public function __toString(): string { return 'Mozzarella Cheese'; } }
class ReggianoCheese implements Cheese { public function __toString(): string { return 'Reggiano Cheese'; } }
class FrozenClams implements Clams { public function __toString(): string { return 'Frozen Clams'; } }
class FreshClams implements Clams { public function __toString(): string { return 'Fresh Clams'; } }
class SpicyPepperoni implements Pepperoni { public function __toString(): string { return 'Spicy Pepperoni'; } }

// Pizza Ingredient Factory implementations
class NYPizzaIngredientFactory implements PizzaIngredientFactory {
    public function createDough(): Dough { return new ThinCrustDough(); }
    public function createSauce(): Sauce { return new MarinaraSauce(); }
    public function createCheese(): Cheese { return new ReggianoCheese(); }
    public function createClam(): Clams { return new FreshClams(); }
}
class ChicagoPizzaIngredientFactory implements PizzaIngredientFactory {
    public function createDough(): Dough { return new ThickCrustDough(); }
    public function createSauce(): Sauce { return new PlumTomatoSauce(); }
    public function createCheese(): Cheese { return new MozzarellaCheese(); }
    public function createClam(): Clams { return new FrozenClams(); }
}

// Pizza Stores implementations
class NYPizzaStore implements PizzaStore {
    private Dough $dough;
    private Sauce $sauce;
    private Pepperoni $pepperoni;
    private Cheese $cheese;
    private Clams $clams;

    public function __construct(Dough $dough, Sauce $sauce, Pepperoni $pepperoni, Cheese $cheese, Clams $clams) {
        $this->dough  = $dough;
        $this->sauce  = $sauce;
        $this->pepperoni  = $pepperoni;
        $this->cheese = $cheese;
        $this->clams  = $clams;
    }

    public function createPizza(): void {
        echo "NY Pizza ingredients:\n";
        echo " - {$this->dough}\n";
        echo " - {$this->sauce}\n";
        echo " - {$this->pepperoni}\n";
        echo " - {$this->cheese}\n";
        echo " - {$this->clams}\n\n\n";
    }
}
class ChicagoPizzaStore implements PizzaStore {
    private Dough $dough;
    private Sauce $sauce;
    private Cheese $cheese;
    private Clams $clams;

    public function __construct(Dough $dough, Sauce $sauce, Cheese $cheese, Clams $clams) {
        $this->dough  = $dough;
        $this->sauce  = $sauce;
        $this->cheese = $cheese;
        $this->clams  = $clams;
    }

    public function createPizza(): void {
        echo "Chicago Pizza ingredients:\n";
        echo " - {$this->dough}\n";
        echo " - {$this->sauce}\n";
        echo " - {$this->cheese}\n";
        echo " - {$this->clams}\n\n\n";
    }
}

/**
 * MAIN
 */

$nyPizzaStore = new NYPizzaStore(
    new ThinCrustDough(),
    new MarinaraSauce(),
    new SpicyPepperoni(),
    new ReggianoCheese(),
    new FreshClams()
);
$nyPizzaStore->createPizza();


$chicagoPizzaStore = new ChicagoPizzaStore(
    new ThickCrustDough(),
    new PlumTomatoSauce(),
    new MozzarellaCheese(),
    new FrozenClams()
);
$chicagoPizzaStore->createPizza();


