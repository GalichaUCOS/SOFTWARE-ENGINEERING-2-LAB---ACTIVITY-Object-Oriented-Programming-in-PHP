<?php

class Student {
    private $name;
    private $courses = [];
    private $courseFee = 1450;

    public function __construct($name) {
        $this->name = $name;
    }

    public function enrollCourse($courseName) {
        if (!in_array($courseName, $this->courses)) {
            $this->courses[] = $courseName;
        }
    }

    public function deleteCourse($courseName) {
        $index = array_search($courseName, $this->courses);
        if ($index !== false) {
            unset($this->courses[$index]);
            $this->courses = array_values($this->courses); 
        }
    }

    public function getCourses() {
        return $this->courses;
    }

    public function getTotalFee() {
        return count($this->courses) * $this->courseFee;
    }

    public function displayEnrollment() {
        echo "Student Name: {$this->name}\n";
        echo "Enrolled Courses:\n";
        foreach ($this->courses as $course) {
            echo "- {$course}\n";
        }
        echo "Total Enrollment Fee: PHP " . $this->getTotalFee() . "\n";
    }
}

// test sampleeeeeee disregardddd po 
$student = new Student("Juan Dela Cruz");
$student->enrollCourse("Mathematics");
$student->enrollCourse("Science");
$student->enrollCourse("English");
$student->deleteCourse("Science");
$student->displayEnrollment();

?>