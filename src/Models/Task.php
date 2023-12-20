<?php
namespace Todo\Models;

class Task
{
    private int $id;
    private string $name;
    private int $list_id;
    private ?string $checkTask;

    public function setId($id): void
    {
        $this->id = $id;
    }
    public function getId(): int
    {
        return $this->id;
    }
    public function setName($name): void
    {
        $this->name = $name;
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function setListId($list_id): void
    {
        $this->list_id = $list_id;
    }
    public function getListId(): int
    {
        return $this->list_id;
    }
    public function setCheckTask($checkTask): void
    {
        $this->checkTask = $checkTask;
    }
    public function getCheckTask(): ?string
    {
        return $this->checkTask;
    }
}
?>