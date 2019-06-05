<?php
class database
{
    private $conn = null;
    private $result = null;
    private $host ="3.18.90.82";
    private $dbname ="QuanLyDaiLy";
    private $user ="thelastteam";
    private $pass ="123456thelastteam";
    public function connect()
    {
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->dbname);
        if (!$this->conn) {
            echo "Kết Nối Thất Bại!";
            exit();
        } else {
            mysqli_set_charset($this->conn, 'utf8');
        }
        return $this->conn;
    }
    public function execute($sql)
    {
        $this->result = $this->conn->query($sql);
        return $this->result;
    }
    public function getData()
    {
        if ($this->result) {
            $data = mysqli_fetch_array($this->result);
        } else {
            $data = 0;
        }
        return $data;
    }
    public function getAllData($table)
    {
        if ($this->num_rows($table)==0) {
            $data = null;
        } else {
            while ($datas = $this->getData()) {
                $data[] = $datas;
            }
        }
        return $data;
    }
    public function num_rows($table)
    {
        $sql = "SELECT * FROM $table where DeleteFlag = 0";
        $this->execute($sql);
        if ($this->result) {
            $num = mysqli_num_rows($this->result);
        } else {
            $num = 0;
        }
        return $num;
    }
}
