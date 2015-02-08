<?php

namespace BRO\TaskBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
class Task {

    protected $task;
    protected $dueDate;
    
    /**
     * @Assert\Type(type="BRO\TaskBundle\Entity\Category")
     */
    protected $category;

    public function getTask() {
        return $this->task;
    }

    public function setTask($task) {
        $this->task = $task;
    }

    public function getDueDate() {
        return $this->dueDate;
    }

    public function setDueDate(\DateTime $dueDate = null) {
        $this->dueDate = $dueDate;
    }
    
    public function getCategory()
    {
        return $this->category;
    }
    public function setCategory(Category $category = null)
    {
        $this->category = $category;
    }    

}
