<?php

declare(strict_types=1);

namespace WJCrypto\Models;

use PDO;

class DbModel
{
    protected static $conn;

    public function connection(): PDO
    {
        if (!isset(self::$conn)) {
            self::$conn = new PDO("mysql:host=mysql;dbname=wjcrypto;charset=utf8", 'wjcrypt', 'w3bjump!@#', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$conn;
    }

    public function insert(string $tabela, array $dados)
    {
        $pdo = self::connection();
        $colunas = implode(", ", array_keys($dados));
        $valores = ":" . implode(", :", array_keys($dados));
        $sql = "INSERT INTO $tabela ($colunas) VALUES ($valores)";
        $statement = $pdo->prepare($sql);
        foreach ($dados as $key => $value) {
            $statement->bindValue(":$key", $value);
        }
        $statement->execute();

        return $statement;
    }

    public function update(string $tabela, array $dados, string $campo, $valor)
    {
        $pdo = self::connection();
        $novos_valores = "";
        foreach ($dados as $key => $value) {
            $novos_valores .= "$key=:$key, ";
        }
        $novos_valores = substr($novos_valores, 0, -2);
        $sql = "UPDATE $tabela SET $novos_valores WHERE $campo = :campo";
        $statement = $pdo->prepare($sql);
        $statement->bindValue(":campo", $valor);
        foreach ($dados as $key => $value) {
            $statement->bindValue(":$key", $value);
        }
        $statement->execute();

        return $statement;
    }

    public function delete($tabela, $dados)
    {
        $pdo = self::connection();
        $colunas = implode(", ", array_keys($dados));
        $valores = ":" . implode(", :", array_keys($dados));
        $sql = "DELETE FROM $tabela WHERE $colunas = $valores ";
        $statement = $pdo->prepare($sql);
        foreach ($dados as $key => $value) {
            $statement->bindValue(":$key", $value);
        }
        $statement->execute();

        return $statement;
    }

    public function select(string $tabela, array $where = [], $orderBy = null)
    {
        $pdo = self::connection();
        $sql = "SELECT * FROM $tabela";
        if (count($where)) {
            $sql .= " WHERE ";
            $sql .= implode(" AND ", $where);
        }

        if ($orderBy) {
            $sql .= "ORDER BY $orderBy";
        }

        $statement = $pdo->prepare($sql);
        $statement->execute();

        return $statement;
    }
}
