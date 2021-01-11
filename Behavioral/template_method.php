<?php

/** The TEMPLATE METHOD PATTERN defines the skeleton of an algorithm in a method,
 * deferring some steps to subclasses. Template Method lets subclasses redefine
 * certain steps of an algorithm without changing the algorithm's structure.
 */
abstract class CaffeineBeverage {

    /**
     * Template Method
     */
    public function prepareRecipe(): void {
        $this->boilWater();
        $this->brew();
        $this->pourInCup();
        $this->addCondiments();
    }

    private function boilWater(): void { echo "Boiling Water\n"; }
    private function pourInCup(): void { echo "Pouring in a cup\n"; }
    abstract protected function brew(): void;
    abstract protected function addCondiments(): void;
}

class Coffee extends CaffeineBeverage {
    protected function brew(): void { echo "Dripping Coffee through filter\n"; }
    protected function addCondiments(): void { echo "Adding Sugar and Milk\n"; }
}

class Tea extends CaffeineBeverage {
    protected function brew(): void { echo "Steeping the tea\n"; }
    protected function addCondiments(): void { echo "Adding lemon\n"; }
}

/**
 * Helpers
 */
function prepareBeverage(CaffeineBeverage $beberage): void {
    echo sprintf("\n\nPreparing %s\n", get_class($beberage));
    $beberage->prepareRecipe();
}

/**
 * MAIN
 */

prepareBeverage(new Coffee());
prepareBeverage(new Tea());