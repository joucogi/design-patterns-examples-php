<?php

/* COMMAND PATTERN encapsulates a request as an object, thereby letting you parameterize
 * other objects with different requests, queue or long requests, and support undoable
 * operations.
*/

// COMMANDS
interface Command {
    public function execute(): void;
    public function undo(): void;
}

class LightOnCommand implements Command {
    private Light $light;

    public function __construct(Light $light) { $this->light = $light; }

    public function execute(): void {
        $this->light->on();
    }

    public function undo(): void {
        $this->light->off();
    }
}

class GarageDoorOpenCommand implements Command {
    private GarageDoor $garageDoor;

    public function __construct(GarageDoor $garageDoor) { $this->garageDoor = $garageDoor; }

    public function execute(): void {
        $this->garageDoor->up();
    }

    public function undo(): void {
        $this->garageDoor->down();
    }
}

// Receivers
class Light {
    public function on(): void { echo "Light on\n"; }
    public function off(): void { echo "Light off\n"; }
}

class GarageDoor {
    public function up(): void { echo "Garage door up\n"; }
    public function down(): void { echo "Garage door down\n"; }
}

// Controller
class RemoteControl {
    private array $commands;
    public function __construct(Command ...$commands) {
        $this->commands = [];
        foreach ($commands as $command) {
            $this->commands[] = $command;
        }
    }
    public function onButtonWasPressed(int $position = 0): void {
        try {
            $this->guard($position);
            $this->commands[$position]->execute();
        } catch(Exception $e) {
            echo $e->getMessage();
        }
    }
    public function offButtonWasPressed(int $position = 0): void {
        try {
            $this->guard($position);
            $this->commands[$position]->undo();
        } catch(Exception $e) {
            echo $e->getMessage();
        }
    }

    private function guard(int $position): void {
        if (!isset($this->commands[$position])) {
            throw new RuntimeException("Button $position is not configured\n");
        }
    }
}

/**
 * MAIN
 */
$lightOnCommand = new LightOnCommand(new Light());
$garageDoorOpenCommand = new GarageDoorOpenCommand(new GarageDoor());

$RemoteControl = new RemoteControl($lightOnCommand, $garageDoorOpenCommand);
$RemoteControl->onButtonWasPressed(0);
$RemoteControl->onButtonWasPressed(1);
$RemoteControl->offButtonWasPressed(1);
$RemoteControl->offButtonWasPressed(0);
$RemoteControl->onButtonWasPressed(2);
$RemoteControl->offButtonWasPressed(2);

