<?php
session_start();
include 'check.php';
include 'include/config.php';
include 'include/para.php';

//$rs = $db->execute("select * from " . TABLE_PREFIX . "users");
//if ($db->num_rows($rs) != 0) {
//    $rows = $db->fetch_array($rs);
//    $db->free_result($rs);
//}

$pageUrl = $_SERVER['PHP_SELF'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>修改密码 - <?php echo $gb_name ?></title>
    <link href="css/css.css" rel="stylesheet" type="text/css">
</head>
<script language=JavaScript>
    function FrontPage_Form1_Validator(theForm) {
        if (theForm.admin_pass.value == "") {
            alert("请填写原密码！");
            theForm.admin_pass.focus();
            return (false);
        }
        if (theForm.password.value == "") {
            alert("新密码还没有填呢！！");
            theForm.password.focus();
            return (false);
        }
        if (theForm.password.value.length < 6) {
            alert("密码过于简单！最低6个字符");
            theForm.password.focus();
            return (false);
        }
        if (theForm.admin_pass2.value == "") {
            alert("确认密码还没有填！！");
            theForm.admin_pass2.focus();
            return (false);
        }
        if(theForm.password.value==theForm.admin_pass.value){
            alert("新密码与旧密码相同");
            theForm.password.focus();
            return (false);
        }
        if (theForm.password.value != theForm.admin_pass2.value) {
            alert("密码不一致！！！");
            theForm.admin_pass2.focus();
            return (false);
        }
        return (true);
    }
</script>
<body>
<div id="main">
    <?php include 'include/head.php'; ?>
    <div id="submit">
        <?php if (empty($_POST['ac'])) { ?>
            <form name="form1" method="post" action="<?php $_SERVER['PHP_SELF'] ?>"
                  onsubmit="return FrontPage_Form1_Validator(this)">
                <p><img src="images/admin_set.gif"/><img src="images/set.gif"/></p><br/>
                <div id="submit_set_left">
                    <ul>
                        <?php if($_SESSION['role']==1 or$_SESSION['role']==2){?>
                        <li><a href="user_modify_passwd.php">修改密码</a>
                            <?php } if($_SESSION['role']==2){?>
                        <li><a href="user_modify_info.php">修改个人信息</a> </li>
                    <?php } if($_SESSION['role']==1) {?>
                        <li><a href="admin_set.php">系统参数设置</a>
                            <?php }?>
                    </ul>
                </div>

                <div id="submit_set_right">
                    <label for="admin_pass">原始密码：</label><input type="text" name="admin_pass"/>*<br/>
                    <label for="password">新密码：</label><input type="text" name="password"/>*<br/>
                    <label for="admin_pass2">确认新密码：</label><input type="text" name="admin_pass2"/>*<br/>
                    <input type="submit" id="sbutton" name="Submit" value="　确认修改　">
                    <input name="ac" type="hidden" id="ac" value="modify">
                </div>
                <div class="clear"></div>
            </form>
        <?php } else { ?>
            <div id="alertmsg">
                <?php
                include 'include/config.php';
                $admin_user = $_SESSION['username'];
                $oldpassword = $_POST['admin_pass'];
                $confirmpassword = $_POST['admin_pass2'];
                $newpassword = $_POST['password'];
//                $rs = $db->execute("select name,password from " . TABLE_PREFIX . "users where password='" . $_POST['admin_pass']);
                $rs = $db->execute("select password from " . TABLE_PREFIX . "users where account='" . $admin_user . "'");
                $row = $db->fetch_array($rs);
                if ($row['password']==$oldpassword) {
                    if($confirmpassword==$newpassword){
//                        $db->execute("update " . TABLE_PREFIX . "users set password='" . $newpassword." where account=".$admin_user);
                        $update_sql="update mb_users set password='".$newpassword."' where account='".$admin_user . "'";
                        $rs = $db->execute($update_sql);

                        echo "修改密码成功！<br><a href=" . $pageUrl . ">如果浏览器没有自动返回，请点击此处返回</a>";
                        echo "<meta http-equiv=\"refresh\" content=\"2; url=" . $pageUrl . "\">";
                    }
//                    else{
//                        echo "操作失败！两次密码不一致<br>";
//                        echo "<meta http-equiv=\"refresh\" content=\"2; url=" . $pageUrl . "\">";
//                    }

                } else {
                    echo "操作失败！原始密码不正确，正在返回……<br><a href=" . $pageUrl . ">如果浏览器没有自动返回，请点击此处返回</a>";
                    echo "<meta http-equiv=\"refresh\" content=\"2; url=" . $pageUrl . "\">";
                }
                $db->free_result($rs);
                ?>
            </div>
        <?php } ?>
    </div>
</div>
<?php include 'include/foot.php'; ?>
</body>
</html>