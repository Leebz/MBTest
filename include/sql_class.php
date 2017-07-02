<?php

class db_Mysql
{
    /**用户名
     * @var String
     */
    var $dbServer;//服务器地址
    var $dbbase; //数据库名
    var $dbUser;  //用户名
    var $dbPwd;   //用户密码
    var $dbLink;   //数据库连接
    var $result;// 执行query命令的指针
    var $num_rows;// 返回的条目数
    var $insert_id;// 传回最后一次使用 INSERT 指令的 ID
    var $affected_rows;// 传回query命令所影响的列数目

    /**
     * 取得数据库连接，并赋值给dbLink,若不能连接则返回错误提示
     *
     */
    function dbconnect()
    {
        $this->dbLink = @mysqli_connect($this->dbServer, $this->dbUser, $this->dbPwd,$this->dbbase);
        if(mysqli_connect_errno($this->dbLink)){
            echo "不能连接数据库";
        }
        mysqli_query($this->dbLink,"SET NAMES 'utf8'");
    }
    /*
     * 执行相应的sql语句
     */

    function execute($sql)
    {
        $this->result = mysqli_query($this->dbLink,$sql);
        return $this->result;
    }

    function fetch_array($result)
    {
        return mysqli_fetch_array($result);
    }

    public function get_rows($sql)
    {
        return mysqli_num_rows(mysqli_query($this->dbLink,$sql));
    }

    function num_rows($result)
    {
        return mysqli_num_rows($result);
    }

    function get_affected_rows(){
        return mysqli_affected_rows($this->dbLink);
    }

    function dbhalt($errmsg)
    {
        $msg = "database is wrong!";
        $msg = $errmsg;
        echo "$msg";
        die();
    }

    function delete($sql)
    {
        $result = $this->execute($sql);
        $this->affected_rows = mysqli_affected_rows($this->dbLink);
        $this->free_result($result);
        return $this->affected_rows;
    }

    function insert($sql)
    {
        $result = $this->execute($sql);
        $this->insert_id = mysql_insert_id($this->dbLink);
        $this->free_result($result);
        return $this->insert_id;
    }

    function update($sql)
    {
        $result = $this->execute($sql);
        $this->affected_rows = mysqli_affected_rows($this->dbLink);
        $this->free_result($result);
        return $this->affected_rows;
    }

    function get_num($result)
    {
        $num = @mysqli_numrows($result);
        return $num;
    }

    function free_result($result)
    {
        @mysqli_free_result($result);
    }

    function dbclose()
    {
        mysqli_close($this->dbLink);
    }

}// end class
?>

