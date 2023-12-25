<?php

namespace Todo\Controllers;

use Todo\Models\TaskManager;
use Todo\Validator;

/** Class UserController **/
class TaskController
{
    private $manager;
    private $validator;

    public function __construct()
    {
        $this->manager = new TaskManager();
        $this->validator = new Validator();
    }

    public function create()
    {
        if (!isset($_SESSION["user"]["username"])) {
            header("Location: /login");
            die();
        }
        require VIEWS . 'Todo/show.php';
    }

    public function store()
    {
        if (!isset($_SESSION["user"]["username"])) {
            header("Location: /login");
            die();
        }
        $this->validator->validate([
            "nameTask" => ["required", "min:2", "alphaNumDash"]
        ]);
        $_SESSION['old'] = $_POST;

        if (!$this->validator->errors()) {
            $this->manager->store();
        }
        header("Location: /dashboard/" . $_POST["nameList"]);
    }
    public function check()
    {
        if (!isset($_SESSION["user"]["username"])) {
            header("Location: /login");
            die();
        }
        $check = $_POST["check"];
        if ($check == "no") {
            $check = "yes";
        } else {
            $check = "no";
        }
        $this->manager->check($check);
        header("Location: /dashboard/" . $_POST["nameList"]);
    }
    public function delete()
    {
        if (!isset($_SESSION["user"]["username"])) {
            header("Location: /login");
            die();
        }
        $this->manager->delete();
        header("Location: /dashboard/" . $_POST["nameList"]);
    }

    public function update()
    {
        if (!isset($_SESSION["user"]["username"])) {
            header("Location: /login");
            die();
        }
        $this->validator->validate([
            "nameTodo" => ["required", "min:2", "alphaNumDash"]
        ]);
        $_SESSION['old'] = $_POST;
        $this->manager->update($_POST["nameTask"]);
        header("Location: /dashboard/" . $_POST["nameTodo"]);
    }
}
?>