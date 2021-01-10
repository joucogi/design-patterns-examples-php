<?php

/*** SINGLETON PATTERN ensures a class has only one instance,
 *  and provides a global point of access to it.
 */

class Settings {
    static private ?self $instance = null;

    private int $value;

    private function __construct(){ $this->value = 0; }

    public static function getInstance(): self {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function value(): int {
        return $this->value;
    }

    public function setValue(int $value): void {
        $this->value = $value;
    }

    public function __toString(): string { return "Settings value is {$this->value()}"; }
}

/**
 * MAIN
 */
$settings = Settings::getInstance();
echo "\$settings $settings\n";
$settings->setValue(5);
echo "\$settings $settings\n";
$settings2 = Settings::getInstance();
echo "\$settings2 $settings2\n";
$settings2->setValue(7);
echo "\$settings2 $settings2\n";
echo "\$settings $settings\n";