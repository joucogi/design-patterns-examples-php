<?php

/**
 * The STATE PATTERN allows an object to alter its behavior when its internal state changes.
 * The object will appear to change its class
 */

interface State {
    public function insertQuarter(): void;

    public function ejectQuarter(): void;

    public function turnCrank(): void;

    public function dispense(): void;
}

final class SoldOutState implements State {
    public function __construct(private GumballMachine $gumballMachine) { }

    public function insertQuarter(): void { echo "You can't insert a quarter, the machine is sold out\n"; }

    public function ejectQuarter(): void { echo "You can't eject, you haven't inserted a quarter yet\n"; }

    public function turnCrank(): void { echo "You turned, but there are no gumballs\n"; }

    public function dispense(): void { echo "No gumball dispensed\n"; }
}

final class NoQuarterState implements State {
    public function __construct(private GumballMachine $gumballMachine) { }

    public function insertQuarter(): void {
        echo "You inserted a quarter\n";
        $this->gumballMachine->setHasQuarterState();
    }

    public function ejectQuarter(): void { echo "You haven't inserted a quarter\n"; }

    public function turnCrank(): void { echo "You turned, but there's no quarter\n"; }

    public function dispense(): void { echo "You need to pay first\n"; }
}

final class HasQuarterState implements State {
    public function __construct(private GumballMachine $gumballMachine, private WinnerGenerator $generator) { }

    public function insertQuarter(): void { echo "You can't insert another quarter\n"; }

    public function ejectQuarter(): void {
        echo "Quarter returned\n";
        $this->gumballMachine->setNoQuarterState();
    }

    public function turnCrank(): void {
        echo "You turned...\n";
        if ($this->generator->isAWinner() && $this->gumballMachine->count() > 1) {
            $this->gumballMachine->setWinnerState();
        } else {
            $this->gumballMachine->setSoldState();
        }
    }

    public function dispense(): void { echo "No gumball dispensed\n"; }
}

final class SoldState implements State {
    public function __construct(private GumballMachine $gumballMachine) { }

    public function insertQuarter(): void { echo "Please wait, We're already giving you a gumball\n"; }

    public function ejectQuarter(): void { echo "Sorry, you already turned the crank\n"; }

    public function turnCrank(): void { echo "Turning twice doesn't get you another gumball\n"; }

    public function dispense(): void {
        $this->gumballMachine->releaseBall();
        if ($this->gumballMachine->count() > 0) {
            $this->gumballMachine->setNoQuarterState();
        } else {
            echo "Oops, out of gumballs\n";
            $this->gumballMachine->setSoldOutState();
        }
    }
}

final class WinnerState implements State {
    public function __construct(private GumballMachine $gumballMachine) { }

    public function insertQuarter(): void { echo "Please wait, We're already giving you a gumball\n"; }

    public function ejectQuarter(): void { echo "Sorry, you already turned the crank\n"; }

    public function turnCrank(): void { echo "Turning twice doesn't get you another gumball\n"; }

    public function dispense(): void {
        $this->gumballMachine->releaseBall();
        if ($this->gumballMachine->count() === 0) {
            $this->gumballMachine->setSoldOutState();
        } else {
            $this->gumballMachine->releaseBall();
            echo "YOU'RE A WINNER! You got two gumballs for your quarter";

            if ($this->gumballMachine->count() > 0) {
                $this->gumballMachine->setNoQuarterState();
            } else {
                echo "Oops, out of gumballs\n";
                $this->gumballMachine->setSoldOutState();
            }
        }
    }
}

final class GumballMachine {
    private State $soldOutState;
    private State $noQuarterState;
    private State $hasQuarterState;
    private State $soldState;
    private State $winnerState;

    private State $state;
    private int $numberGumballs = 0;

    public function __construct(int $numberGumballs) {
        $this->soldOutState    = new SoldOutState($this);
        $this->noQuarterState  = new NoQuarterState($this);
        $this->hasQuarterState = new HasQuarterState($this, new RandomWinnerGenerator());
        $this->soldState       = new SoldState($this);
        $this->winnerState     = new WinnerState($this);

        $this->refill($numberGumballs);
    }

    public function insertQuarter(): void { $this->state->insertQuarter(); }

    public function ejectQuarter(): void { $this->state->ejectQuarter(); }

    public function turnCrank(): void { $this->state->turnCrank(); $this->state->dispense(); }

    public function releaseBall(): void {
        echo "A gumball comes rolling out the slot...\n";
        if ($this->numberGumballs > 0) {
            $this->numberGumballs--;
        }
    }

    public function count(): int { return $this->numberGumballs; }
    public function refill(int $numberGumballs) {
        $this->numberGumballs += $numberGumballs;

        if ($this->numberGumballs > 0) {
            $this->state = $this->noQuarterState;
        } else {
            $this->state = $this->soldOutState;
        }
    }

    public function setSoldOutState(): void { $this->state = $this->soldOutState; }

    public function setNoQuarterState(): void { $this->state = $this->noQuarterState; }

    public function setHasQuarterState(): void { $this->state = $this->hasQuarterState; }

    public function setSoldState(): void { $this->state = $this->soldState; }

    public function setWinnerState(): void { $this->state = $this->winnerState; }

    public function __toString(): string {
        $state = get_class($this->state);
        return "\n\nBalls: {$this->numberGumballs} - State: {$state}\n\n";
    }
}

/**
 * Helpers
 */
interface WinnerGenerator {
    public function isAWinner(): bool;
}

final class RandomWinnerGenerator implements WinnerGenerator {
    public function isAWinner(): bool {
        return rand(0, 2) === 0;
    }
}

/**
 * MAIN
 */

$gumballMachine = new GumballMachine(5);

echo $gumballMachine;

$gumballMachine->insertQuarter();
$gumballMachine->turnCrank();

echo $gumballMachine;

$gumballMachine->insertQuarter();
$gumballMachine->ejectQuarter();
$gumballMachine->turnCrank();

echo $gumballMachine;

$gumballMachine->insertQuarter();
$gumballMachine->turnCrank();
$gumballMachine->insertQuarter();
$gumballMachine->turnCrank();
$gumballMachine->ejectQuarter();

echo $gumballMachine;

$gumballMachine->insertQuarter();
$gumballMachine->insertQuarter();
$gumballMachine->turnCrank();
$gumballMachine->insertQuarter();
$gumballMachine->turnCrank();
$gumballMachine->insertQuarter();
$gumballMachine->turnCrank();

echo $gumballMachine;

$gumballMachine->refill(4);

echo $gumballMachine;