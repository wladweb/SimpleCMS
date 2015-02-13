<?php

namespace SimpleCMS\Application\Model;

use PDO;

class IModel {

    protected $db;
    protected $err_log;
    protected $db_data;

    public function __construct() {
        $this->get_db_data();
        $this->err_log = $_SERVER['DOCUMENT_ROOT'] . '/app/model/err.log';
        try {
            $this->db = new PDO(
                    'mysql:dbname=' . $this->db_data['dbname'] . ';host=' . $this->db_data['host'],
                    $this->db_data['user'], $this->db_data['pass']
            );
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            $this->write_log($e->getMessage());
            throw new Exception($e->getMessage());
        }
    }

    public function query($arr, $type = PDO::PARAM_STR) {
        try {
            $sql = array_shift($arr);
            $stmt = $this->db->prepare($sql);
            for ($i = 0, $cnt = count($arr); $i < $cnt; $i++) {
                $stmt->bindParam($i + 1, $arr[$i], $type);
            }
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            $this->write_log($e->getMessage());
            throw new Exception($e->getMessage());
        }
    }

    public function select_found_rows() {
        $arr = array();
        $sql = "SELECT FOUND_ROWS() count_rows";
        $arr[] = $sql;
        $stmt = $this->query($arr);
        return $stmt->fetch(PDO::FETCH_ASSOC)['count_rows'];
    }

    protected function write_log($message) {
        file_put_contents($this->err_log,
                date('m-d-Y H:i:s', time()) . ' - ' . $message . "\n",
                FILE_APPEND);
    }

    protected function get_db_data() {
        $path = $_SERVER['DOCUMENT_ROOT'] . '/setup.ini';
        if (is_file($path)) {
            $this->db_data = parse_ini_file($path);
        } else {
            throw new Exception('Проверьте наличие файла setup.ini');
        }
    }

}
