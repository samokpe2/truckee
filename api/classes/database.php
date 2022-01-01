<?php
 class database{
    public $dbh;


    public function __construct(){
        try {
            $this->dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());

        }


    }




    public function insert($table, $data){
        try {
            $this->dbh->beginTransaction();
        ksort($data);

        $fieldNames = implode('`, `', array_keys($data));
        $fieldValues = ':' . implode(', :', array_keys($data));

        $sth = $this->dbh->prepare("INSERT INTO $table (`$fieldNames`) VALUES ($fieldValues)");

        foreach ($data as $key => $value) {
            $sth->bindValue(":$key", $value);
        }

        $sth->execute();
        $this->dbh->commit();
        return true;
        }catch (PDOException $e){
            $this->dbh->rollback();
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }

    }


    public function deleteAll($table, $where)
    {
        try {
            $this->dbh->beginTransaction();
         $this->dbh->exec("DELETE FROM $table WHERE $where");
            $this->dbh->commit();
        }catch (PDOException $e){
            $this->dbh->rollback();
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function update($table, $data, $where)
    {
        try {
            $this->dbh->beginTransaction();

        ksort($data);

        $fieldDetails = NULL;
        foreach($data as $key=> $value) {
            $fieldDetails .= "$key=:$key,";
        }
        $fieldDetails = rtrim($fieldDetails, ',');
        // $fieldNames = implode('`, `', array_keys($data));
        // $fieldValues = ':' . implode(', :', array_keys($data));

        $sth = $this->dbh->prepare("UPDATE $table SET $fieldDetails WHERE $where");

        foreach ($data as $key => $value) {
            $sth->bindValue(":$key", $value);
        }

         $sth->execute();
            $this->dbh->commit();
            return true;
        }catch (PDOException $e){
            $this->dbh->rollback();
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function view($sql, $array = array(), $fetchMode = PDO::FETCH_ASSOC)
    {
        try {
            $this->dbh->beginTransaction();
        $sth = $this->dbh->prepare($sql);
        foreach ($array as $key => $value) {
            $sth->bindValue("$key", $value);
        }

        $sth->execute();
            $this->dbh->commit();
        return $sth->fetchAll($fetchMode);


        }catch (PDOException $e){
            $this->dbh->rollback();
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function viewAndCount($sql, $array = array(), $fetchMode = PDO::FETCH_ASSOC)
    {
        try {
            $this->dbh->beginTransaction();
        $sth = $this->dbh->prepare($sql);
        foreach ($array as $key => $value) {
            $sth->bindValue("$key", $value);
        }

        $sth->execute();
        $sth->fetchAll($fetchMode);
            $this->dbh->commit();
        return $sth->rowCount();
        }catch (PDOException $e){
            $this->dbh->rollback();
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }



}