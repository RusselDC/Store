<?php


namespace Core;
use Core\App;
use Core\Database;


class InputRules
{
    protected $errors = [];
    protected $conn;

    private function __construct()
    {
        $conn = App::resolve(Database::class);
    }

    public function validate($inputs)
    {
        foreach ($inputs as $field => $details) {
            $value = $_POST[$field] ?? null;
            $rules = explode('|', $details['rules']);
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

    protected function required($field, $value)
    {
        if (empty($value)) {
            $this->errors[$field][] = "$field is required.";
        }
    }

    protected function min($field, $value, $min)
    {
        if (strlen($value) < $min) {
            $this->errors[$field][] = "$field must be at least $min characters.";
        }
    }

    protected function max($field, $value, $max)
    {
        if (strlen($value) > $max) {
            $this->errors[$field][] = "$field must be no more than $max characters.";
        }
    }

    protected function length($field, $value, $length)
    {
        if (strlen($value) != $length) {
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

    // Add more custom validation methods as needed
}


/*
use case


<?php

require 'InputRules.php';

$rules = [
    'name' => [
        'rules' => 'required|string|min:3|max:50'
    ],
    'email' => [
        'rules' => 'required|email|unique:users,email'
    ],
    'age' => [
        'rules' => 'required|number|min:18|max:99'
    ]
];

$validator = new InputRules();

if ($validator->validate($rules)) {
    echo "Validation passed!";
    // Process the validated data
} else {
    echo "Validation failed!";
    print_r($validator->errors());
}
*/