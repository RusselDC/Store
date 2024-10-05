<?php


namespace Core;
use Core\App;
use Core\Database;


class InputRules
{
    protected $errors = [];
    protected $conn;

    public function __construct()
    {
        $this->conn = App::resolve(Database::class);
    }

    public function validate($inputs)
    {
        
        foreach ($inputs as $field => $details) {
            
            $value = $_POST[$field] ?? null;
            $rules = explode('|', $details);
            foreach ($rules as $rule) {
                if (strpos($rule, ':')) {
                    list($ruleName, $ruleValue) = explode(':', $rule);
                    
                    $this->$ruleName($field, $value, $ruleValue);
                } else {
                    $this->$rule($field, $value);
                }
            }
        }

        return empty($this->errors);
    }

    public function errors()
    {
        return $this->errors;
    }

    protected function date($field, $value)
    {
        if (!strtotime($value)) {
            $this->errors[$field][] = "$field must be a valid date.";
        }
    }

    protected function image($field, $value)
    {
        if(isset($_FILES[$field]))
        {
            $image = $_FILES[$field];
            $imageType = explode('/', $image['type'])[0];
            if ($imageType !== 'image') {
                $this->errors[$field][] = "$field must be an image.";
            }
        }
    }

    protected function required($field, $value)
    {
        if (empty($value)) {
            $this->errors[$field][] = "$field is required.";
        }
    }

    protected function min($field, $value, $min)
    {
        if ($value !== null && strlen($value) < $min) {
            $this->errors[$field][] = "$field must be at least $min characters.";
        }
        
    }

    protected function max($field, $value, $max)
    {
        if ($value !== null && strlen($value) > $max) {
            $this->errors[$field][] = "$field must be no more than $max characters.";
        }
    }

    protected function length($field, $value, $length)
    {
        if ($value !== null && strlen($value) != $length) {
            $this->errors[$field][] = "$field must be exactly $length characters.";
        }
    }

    protected function email($field, $value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field][] = "$field must be a valid email address.";
        }
    }

    protected function number($field, $value)
    {
        if (!is_numeric($value)) {
            $this->errors[$field][] = "$field must be a number.";
        }
    }

    protected function string($field, $value)
    {
        if (!is_string($value)) {
            $this->errors[$field][] = "$field must be a string.";
        }
    }

    protected function float($field, $value)
    {
        if (!filter_var($value, FILTER_VALIDATE_FLOAT)) {
            $this->errors[$field][] = "$field must be a float.";
        }
    }

    protected function double($field, $value)
    {
        if (!is_double($value)) {
            $this->errors[$field][] = "$field must be a double.";
        }
    }

    protected function file($field, $value)
    {
        if (!isset($_FILES[$field])) {
            $this->errors[$field][] = "$field must be a valid file.";
        }
    }

    protected function unique($field, $value, $tableData)
    {
        $tableData = explode(',', $tableData);
        $table = $tableData[0];
        $column = $tableData[1];
        $unique = $this->conn->unique($table, $column, $value);
        
        if ($unique) {
            $this->errors[$field][] = "$field already exists.";
        }
        
    }

    protected function exists($field, $value, $tableData)
    {
        $tableData = explode(',', $tableData);
        $table = $tableData[0];
        $column = $tableData[1];
        $unique = $this->conn->unique($table, $column, $value);
        if (!$unique) {
            $this->errors[$field][] = "$field does not exist.";
        }
        
    }

    protected function same($field, $value, $field2)
    {
        if ($value !== $_POST[$field2]) {
            $this->errors[$field][] = "$field must be the same as $field2.";
        }
    }

    protected function lessThan($field, $value, $tableData)
    {
        
        $tableData = explode(',', $tableData);
        $table = $tableData[0];
        $column = $tableData[1];
        $id = $tableData[2];
        $newTable = $this->conn->find($table, $id);
        if ($value > $newTable[$column]) {
            $this->errors[$field][] = "$field must be less than $column.";
        }
    }

    protected function moreThan($field, $value, $tableData)
    {
        $tableData = explode(',', $tableData);
        $table = $tableData[0];
        $column = $tableData[1];
        $id = $tableData[2];
        $newTable = $this->conn->find($table, $id);
        if ($value < $newTable[$column]) {
            $this->errors[$field][] = "$field must be more than $column.";
        }
    }

    

    // Add more custom validation methods as needed
}
