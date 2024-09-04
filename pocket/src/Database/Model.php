<?php

namespace Atomir\AtomirCore\Database;


// CRUD CREAT READ UPDATE DELETE
use PDO;
use PDOStatement;

class Model extends Database
{
    protected string $table;
    protected PDOStatement $statement;
    protected int $fetchMode = PDO::FETCH_OBJ;
    protected array $selectedItems = [];

    protected ?int $limit;

    protected array $whereList = [];

    protected array $valuesForBind = [];

    public function __construct()
    {
        parent::__construct();
    }

    public function create(array $data)
    {

        $keysOfData = array_keys($data);

        $fields = implode(",", $keysOfData);
        $params = implode(",", array_map(fn($key) => ":$key", $keysOfData));

        $this->statement = $this->pdo->prepare("INSERT INTO `{$this->table}` ($fields) VALUES ($params)");
        $this->bindValues($data);


        return $this->statement->execute();

    }

    public function update(int $id, array $data): bool
    {

        $fieldsOfUpdate = array_map(fn($key) => "$key = :$key", array_keys($data));
        $fieldsOfUpdate = implode(",", $fieldsOfUpdate);
        $this->statement = $this->pdo->prepare("UPDATE `{$this->table}` SET $fieldsOfUpdate WHERE `id` = :id");
        $this->bindValues(array_merge($data, ['id' => $id]));
        return $this->statement->execute();

    }

    public function delete(int $id): bool
    {

        $this->statement = $this->pdo->prepare("DELETE FROM `{$this->table}` WHERE `id` = :id");

        $this->bindValues(["id" => $id]);

        return $this->statement->execute();

    }

    public function select(): self
    {
        $this->selectedItems = func_get_args();

        return $this;
    }

    public function limit(int $limit): self
    {
        $this->limit = $limit;
        return $this;
    }


    public function where(string $name, string|bool|int $value, string $operator = "="): self
    {

        $this->whereList[] = "$name $operator :$name";
        $this->valuesForBind[$name] = $value;
        return $this;
    }

    public function result(): self
    {

        $query = ["SELECT"];
        $query[] = count($this->selectedItems) ? implode(",", $this->selectedItems) : "*";

        $query[] = "FROM `{$this->table}`";

        if (count($this->whereList)) {
            $query[] = $this->prepareWhereStatement();
        }

        if (!empty($this->limit)) {
            $query[] = "LIMIT {$this->limit}";
        }

        $this->statement = $this->pdo->prepare(implode(" ", $query));
        $this->bindValues();
        $this->statement->execute();
        return $this;
    }


    protected function prepareWhereStatement(): string
    {
        $query[] = "WHERE";

        foreach ($this->whereList as $key => $value) {
            if ($key !== array_key_first($this->whereList)) $query[] = "AND";
            $query[] = $value;
        }

        return implode(" ", $query);
    }


    public function find($value, $field = 'id')
    {
        return $this->where($field, $value)->first();
    }

    public function get(): bool|array
    {
        return $this->result()->fetch();
    }

    public function first()
    {
        return $this->limit(1)->result()->fetch('fetch');
    }

    public function fetch($fetchMethod = 'fetchAll')
    {
        return $this->statement->{$fetchMethod}($this->fetchMode);
    }

    protected function bindValues(?array $data = null): void
    {
        if ($data) {
            $this->valuesForBind = array_merge($this->valuesForBind, $data);
        }

        foreach ($this->valuesForBind as $key => $value) {
            $this->statement->bindValue($key, $value);
        }
    }

}