<?php
require_once '../config/DbConfig.php';

class Model{
    protected $db;

    public function __construct(){
        try{
            $this->db = newPDO("mysql:host={$DB_HOST};db_name={$DB_NAME}",$DB_USER,$DB_NAME);
            $this->db->setAttribute(PDO:ATTR_ERRMODE,PDO:ERRMODE_EXCEPTION);
        }catch(PDOException $e){
            echo "Database connection failure: " . $e->getMessage();
            exit;
        }
    }

    public function readAll($table)
    {
        $stmt = $this->db->query("SELECT * FROM {$table}");
        return $stmt->fetchAll(PDO:FETCH_ASOOC);
    }

    public function readById($table,$id)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$table} WHERE id = :id");
        $stmt->bindParam(':id',$id,PDO:PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO:FETCH_ASSOC);
    }

    public function create($table, $data)
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0,count($data),'?'));
        $values = array_values($data);
        $stmt = $this->db->prepare("INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})");
        $stmt->execute($values);
        return $this->db->lastInsertId();
    }

    public function update($table, $data, $id)
    {
        $set = implode(' = ?, ',array_keys($data)) . ' = ? ';
        $values = array_values($data);
        $values[] = $id;
        $stmt = $this->db->prepare("UPDATE {$table} SET {$set} WHERE id = ?");
        return $stmt->execute($values);
    }

    public function delete($table,$id)
    {
        $stmt = $this->db->prepare("DELETE FROM {$table} WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

}