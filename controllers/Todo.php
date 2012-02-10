<?php

class Todo
{
    private $_params;

    public function __construct($params)
    {
        $this->_params = $params;
    }

    public function createAction(){
        $todo = new TodoItem();
        $todo->title = $this->_params['title'];
        $todo->description = $this->_params['description'];
        $todo->due_date = $this->_params['due_date'];
        $todo->is_done = 'false';

        $todo->save($this->_params['username'], $this->_params['userpass']);
        return $todo->toArray();
    }

    public function readAction(){
		$todo_items = TodoItem::getAllItems($this->_params['username'], $this->_params['userpass']);
		return $todo_items;
    }

    public function updateAction(){
    }

    public function deleteAction(){
    }
}
