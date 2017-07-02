<?php
class Page{
    var $pagesize;  //一页显示的留言数量
    var $numrows;   //一共的数据量
    var $pages;      //全部的页数
    var $page;      //请求的页码
    var $offset;    //偏移量
    var $url;
    function pagedate($str1,$str2,$str3){
        global $pagesize,$offset;
        $this->pagesize = $str1;
        $this->numrows = $str2;
        $this->url    = $str3;
        $this->pages    = intval($this->numrows/$this->pagesize);
        if($this->numrows%$this->pagesize){
            $this->pages ++;
        }
        $nPage = $_GET['page'];
        if($nPage != null && !preg_match("/^\d+$/",$nPage)){
            echo("错误的参数类型！");
            return false;
        }
        if(isset($nPage)){
            $this->page = intval($nPage);
        }
        else{
            $this->page = 1;
        }
        if($nPage < 1 || $nPage > $this->pages){
            $this->page = 1;
        }
        $this->offset = $this->pagesize * ($this->page - 1);
        $pagesize = $this->pagesize;
        $offset = $this->offset;
    }

    function pageshow(){
        echo "第[" . $this->page . "/" . $this->pages . "]页　";

        for($i = 1 ; $i <= $this->pages ; $i ++){
            if($i == $this->page){
                echo "<span>".$i."</span>";
            }else{
                echo "<a href='" . $this->url . "=" . $i . "'>" . $i . "</a>";
            }
        }
    }
}
?>