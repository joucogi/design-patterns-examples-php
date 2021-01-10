<?php

/*** FACTORY METHOD PATTERN defines an interface for creating an object, but lets subclasses
 *  decide which class to instantiate. Factory method lets a class defer instantiation to subclasses.
 */

class PizzaStore {
    private SimplePizzaFactory $factory;

    public function __construct(SimplePizzaFactory $factory) { $this->factory = $factory; }
    public function orderPizza(string $type = ''): void {
        $pizza = $this->factory->createPizza($type);
        $pizza->prepare();
        $pizza->bake();
        $pizza->cut();
        $pizza->box();
    }
}

class SimplePizzaFactory {
    public function createPizza(string $type = ''): Pizza {
        switch ($type) {
            case 'cheese': return new CheesePizza();
            case 'veggie': return new VeggiePizza();
            case 'clam': return new ClamPizza();
            case 'pepperoni': return new PepperoniPizza();
            default: return new MargaritaPizza();
        }
    }
}

abstract class Pizza {
    abstract public function name(): string;
    public function prepare(): void { echo "- Preparing a {$this->name()}\n"; }
    public function bake(): void { echo "- Baking a {$this->name()}\n"; }
    public function cut(): void { echo "- Cutting a {$this->name()}\n"; }
    public function box(): void { echo "- Boxing a {$this->name()}\n"; }
}

class CheesePizza extends Pizza { public function name(): string { return 'Cheese pizza'; }}
class VeggiePizza extends Pizza { public function name(): string { return 'Veggie pizza'; }}
class ClamPizza extends Pizza { public function name(): string { return 'Clam pizza'; }}
class PepperoniPizza extends Pizza { public function name(): string { return 'Pepperoni pizza'; }}
class MargaritaPizza extends Pizza { public function name(): string { return 'Margarita pizza'; }}

$pizzaStore = new PizzaStore(new SimplePizzaFactory());
$pizzaStore->orderPizza('cheese');
$pizzaStore->orderPizza('pepperoni');
$pizzaStore->orderPizza();