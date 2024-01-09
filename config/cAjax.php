<?php
require_once 'cCon.php';


abstract class cAjax
{
    static function insertDadosFromTable($data, $tableName)
    {
        try {

            $pdo = Conn::conectar();
            $pdo->beginTransaction();

            // Verifica se o campo 'password' está presente no array $data
            if (isset($data['password']) && !empty($data['password'])) {
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            }

            $columns = implode(', ', array_keys($data));
            $values = ':' . implode(', :', array_keys($data));

            $query = "INSERT INTO $tableName ($columns) VALUES ($values)";

            $statement = $pdo->prepare($query);

            foreach ($data as $key => $value) {
                $statement->bindValue(":$key", $value);
            }

            $res = $statement->execute();

            $pdo->commit();

            return [
                "status" => 'success',
                "response" => $res
            ];
        } catch (\Throwable $th) {
            $pdo->rollBack();
            throw $th;
        }
    }

    static function getDadosFromTablesParametro($tableName, $parametro, $value)
    {
        try {
            $pdo = Conn::conectar();

            // Assuming the parameter corresponds to the field name
            $sql = "SELECT * FROM $tableName WHERE $parametro = :value";

            $stm = $pdo->prepare($sql);
            $stm->bindValue(':value', $value); // Binding the parameter value
            $stm->execute();
            $getAll = $stm->fetchAll(PDO::FETCH_ASSOC);

            return $getAll;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    static function getDadosFromTables($tableName)
    {
        try {
            $pdo = Conn::conectar();
            // Assuming the parameter corresponds to the field name
            $sql = "SELECT * FROM $tableName"; 
            $stm = $pdo->prepare($sql);
            $stm->execute();
            $getAll = $stm->fetchAll(PDO::FETCH_ASSOC);

            return $getAll;
        } catch (\Throwable $th) {
            throw $th;
        }
    }



    static function deleteDadosFromTables($tableName, $id)
    {
        try {
            $pdo = Conn::conectar();

            // Desativa temporariamente as verificações de chave estrangeira
            $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");

            $sql = "DELETE FROM `$tableName` WHERE id = :id";
            $stm = $pdo->prepare($sql);
            $stm->bindValue(":id", $id);
            $success = $stm->execute();

            // Ativa as verificações de chave estrangeira novamente
            $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");

            if ($success) {
                return [
                    'status' => 'sucesso ao remover os dados!'
                ];
            } else {
                return [
                    'status' => 'error ao remover os dados!'
                ];
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    static function updateDadosFromTable($data, $tableName, $recordId )
    {
        try {
            $pdo = Conn::conectar();
            $pdo->beginTransaction();
    
            // Verifica se o campo 'password' está presente no array $data
            if (isset($data['password']) && !empty($data['password'])) {
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            }
    
            $setColumns = [];
            foreach ($data as $key => $value) {
                $setColumns[] = "$key = :$key";
            }
            $setClause = implode(', ', $setColumns);
    
            $query = "UPDATE $tableName SET $setClause WHERE id = :id";
            $statement = $pdo->prepare($query);
    
            foreach ($data as $key => $value) {
                $statement->bindValue(":$key", $value);
            }
            $statement->bindValue(":id", $recordId);
    
            $res = $statement->execute();
    
            $pdo->commit();
            return [
                "status" => 'success',
                "response" => $res
            ];
        } catch (\Throwable $th) {
            $pdo->rollBack();
            return [
                "status" => 'error',
                "error_message" => $th->getMessage()
            ];
        }
    }
}
