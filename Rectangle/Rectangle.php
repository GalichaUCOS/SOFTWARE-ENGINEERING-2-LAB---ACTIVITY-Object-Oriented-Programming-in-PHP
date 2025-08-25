<?php
class Rectangle {
    private $width;  
    private $height; 
    
    public function __construct($width = 1.0, $height = 1.0) { 
        $this->width = $width;
        $this->height = $height;
    }
    
    public function getArea() {      
        return $this->width * $this->height;
    }
    
    public function getPerimeter() {
        return 2 * ($this->width + $this->height);
    }
}
?>