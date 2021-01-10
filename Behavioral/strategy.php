<?php

/*** STRATEGY PATTERN defines a family of algorithms, encapsulates each one, and makes them
 * interchangeable. Strategy lets the algorithm vary independently from clients that use it.
*/

interface AnalyzeViruses {
    public function analyze(): void;
}

class SimpleAnalyzeViruses implements AnalyzeViruses {
    public function analyze(): void {
        echo "Analyze not compressed files.\n";
    }
}

class AdvancedAnalyzeViruses implements AnalyzeViruses {
    public function analyze(): void {
        echo "Analyze not compressed files.\n";
        echo "Analyze compressed files.\n";
    }
}

class Antivirus {
    private AnalyzeViruses $analyzer;

    public function __construct(AnalyzeViruses $analyzer) { $this->analyzer = $analyzer; }
    public function analyze(): void { $this->analyzer->analyze(); }
}

echo "SIMPLE ANTIVIRUS\n";
echo "----------------\n";
$simpleAntivirus = new Antivirus(new SimpleAnalyzeViruses());
$simpleAntivirus->analyze();

echo "\nADVANCED ANTIVIRUS\n";
echo "----------------\n";
$advancedAntivirus = new Antivirus(new AdvancedAnalyzeViruses());
$advancedAntivirus->analyze();
