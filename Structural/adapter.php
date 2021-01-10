<?php

/*** ADAPTER PATTERN converts the interface of a class into another
 * interface the clients expect. Adapter lets classes work together
 * that couldn't otherwise because of incompatible interfaces.
 */

/**
 * Duck interface and implementation
 */
interface Duck {
    public function quack(): void;

    public function fly(): void;
}

final class MallardDuck implements Duck {
    public function quack(): void {
        echo "Quack\n";
    }

    public function fly(): void {
        echo "I'm flying\n";
    }
}

/**
 * Turkey interface and implementation
 */
interface Turkey {
    public function gobble(): void;

    public function fly(): void;
}

final class WildTurkey implements Turkey {
    public function gobble(): void {
        echo "Gobble gobble\n";
    }

    public function fly(): void {
        echo "I'm flying s ahort distance\n";
    }
}

/**
 * Turkey adapter implementing Duck interface
 */
final class TurkeyAdapter implements Duck {
    private Turkey $turkey;

    public function __construct(Turkey $turkey) {
        $this->turkey = $turkey;
    }

    public function quack(): void {
        $this->turkey->gobble();
    }

    public function fly(): void {
        for ($times = 0; $times < 5; $times++) {
            $this->turkey->fly();
        }
    }
}

/**
 * Helpers
 */
$testDuck = static function (Duck $duck) {
    $duck->quack();
    $duck->fly();
};

/**
 * MAIN
 */
$duck = new MallardDuck();
$turkey = new WildTurkey();
$turkeyAdapter = new TurkeyAdapter($turkey);

echo "The Turkey says...\n";
$turkey->gobble();
$turkey->fly();

echo "\nThe Duck says...\n";
$testDuck($duck);

echo "\nThe TurkeyAdapter says...\n";
$testDuck($turkeyAdapter);


