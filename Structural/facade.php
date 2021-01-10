<?php

/*** FACADE PATTERN provides a unified interface to a set of
 * interfaces in a subsystem. Facade defines a higher-level
 * interface that makes the subsystem easier to use.
 */

class Amplifier {
    private DvdPlayer $dvd;

    public function on(): void { echo "Amplifier ON\n"; }

    public function off(): void { echo "Amplifier OFF\n"; }

    public function setDvd(DvdPlayer $dvd): void {
        echo "Amplifier set dvd player\n";
        $this->dvd = $dvd;
    }

    public function setSurroundSound(): void { echo "Amplifier set surround sound\n"; }

    public function setVolume(int $volume): void { echo "Amplifier set volume to $volume\n"; }
}

class DvdPlayer {
    public function on(): void { echo "DvdPlayer ON\n"; }

    public function off(): void { echo "DvdPlayer OFF\n"; }

    public function play(string $movie): void { echo "DvdPlayer play $movie\n"; }

    public function stop(): void { echo "DvdPlayer stop\n"; }
}

class Screen {
    public function up(): void { echo "Screen UP\n"; }

    public function down(): void { echo "Screen DOWN\n"; }
}

class TheaterLights {
    public function on(): void { echo "TheaterLights ON\n"; }

    public function off(): void { echo "TheaterLights OFF\n"; }
}

/**
 * FACADE
 */
class HomeTheaterFacade {
    private Amplifier     $amplifier;
    private DvdPlayer     $dvd;
    private Screen        $screen;
    private TheaterLights $lights;

    public function __construct(Amplifier $amplifier, DvdPlayer $dvd, Screen $screen, TheaterLights $lights) {
        $this->amplifier = $amplifier;
        $this->dvd       = $dvd;
        $this->screen    = $screen;
        $this->lights    = $lights;
    }

    public function watchMovie(string $movie): void {
        echo "Get ready to watch a movie...\n";
        $this->lights->off();
        $this->screen->down();
        $this->amplifier->on();
        $this->amplifier->setDvd($this->dvd);
        $this->amplifier->setSurroundSound();
        $this->amplifier->setVolume(10);
        $this->dvd->on();
        $this->dvd->play($movie);
    }

    public function endMovie(): void {
        echo "Shutting movie theater down...\n";
        $this->lights->on();
        $this->screen->up();
        $this->amplifier->off();
        $this->dvd->stop();
        $this->dvd->off();
    }
}

/**
 * MAIN
 */

$amplifier = new Amplifier();
$lights    = new TheaterLights();
$screen    = new Screen();
$dvd       = new DvdPlayer();

$homeTheater = new HomeTheaterFacade(
    $amplifier,
    $dvd,
    $screen,
    $lights
);

$homeTheater->watchMovie('Watchmen');
echo "\n\n\n";
$homeTheater->endMovie();