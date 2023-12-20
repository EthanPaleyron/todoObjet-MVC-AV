<?php
namespace Todo\Models;

class TaskManager
{
    private $bdd;

    public function __construct()
    {
        $this->bdd = new \PDO('mysql:host=' . HOST . ';dbname=' . DATABASE . ';charset=utf8;', USER, PASSWORD);
        $this->bdd->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function find($name, $userId)
    {
        $stmt = $this->bdd->prepare("SELECT * FROM task WHERE name = ? AND list_id = ?");
        $stmt->execute(array(
            $name,
            $userId
        ));
        $stmt->setFetchMode(\PDO::FETCH_CLASS, "Todo\Models\Task");

        return $stmt->fetch();
    }

    public function store()
    {
        $stmt = $this->bdd->prepare("INSERT INTO task(name, list_id, checkTask) VALUES (?, ?, 'no')");
        $stmt->execute(array(
            $_POST["nameTask"],
            $_POST["list_id"]
        ));
    }

    public function check($check)
    {
        $stmt = $this->bdd->prepare("UPDATE `task` SET checkTask = ? WHERE id = ?");
        $stmt->execute(array(
            $check,
            $_POST["task_id"]
        ));
    }

    // public function update($slug)
    // {
    //     $stmt = $this->bdd->prepare("UPDATE task SET name = ? WHERE name = ? AND list_id = ?");
    //     $stmt->execute(array(
    //         $_POST['nameTodo'],
    //         $slug,
    //         $_SESSION["user"]["id"]
    //     ));
    // }

    // public function delete($slug)
    // {

    //     $stmt = $this->bdd->prepare("DELETE FROM task WHERE id = ? AND list_id = ?");
    //     $stmt->execute(array(
    //         $_POST["idList"],
    //         $_SESSION["user"]["id"]
    //     ));
    // }

    public function getAll($listId)
    {
        $stmt = $this->bdd->prepare('SELECT * FROM task WHERE list_id = ?');
        $stmt->execute(array(
            $listId
        ));

        return $stmt->fetchAll(\PDO::FETCH_CLASS, "Todo\Models\Task");
    }
}
?>