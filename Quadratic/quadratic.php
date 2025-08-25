<?php
class QuadraticEquation {
    private $a;
    private $b;
    private $c;

    public function __construct($a, $b, $c) {
        $this->a = $a;
        $this->b = $b;
        $this->c = $c;
    }

    public function getA() {
        return $this->a;
    }

    public function getB() {
        return $this->b;
    }

    public function getC() {
        return $this->c;
    }

    public function getDiscriminant() {
        return $this->b * $this->b - 4 * $this->a * $this->c;
    }

    public function getRoot1() {
        $discriminant = $this->getDiscriminant();
        if ($discriminant < 0) {
            return 0;
        }
        return (-$this->b + sqrt($discriminant)) / (2 * $this->a);
    }

    public function getRoot2() {
        $discriminant = $this->getDiscriminant();
        if ($discriminant < 0) {
            return 0;
        }
        return (-$this->b - sqrt($discriminant)) / (2 * $this->a);
    }

}
?>