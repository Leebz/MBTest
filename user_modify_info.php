<?php
session_start();
include 'check.php';
include 'include/config.php';
include 'include/para.php';

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
        if (theForm.nickname.value == "") {
            alert("请填写昵称！");
            theForm.nickname.focus();
            return (false);
        }
        if(theForm.email.value==""){
            alert("请填写邮箱");
            theForm.email.focus();
            return (false);
        }
        if (theForm.nickname.value.length<3)
        {
            alert("昵称至少应为3个字符！");
            theForm.nickname.focus();
            return (false);
        }
        if(theForm.email.value!=""){
            var email1 = theForm.email.value;
            var pattern = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-])+/;
            flag = pattern.test(email1);
            if(!flag){
                alert("邮件地址格式不对！");
                theForm.email.focus();
                return false;}
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

                <?php
                    $username = $_SESSION['username'];
                    $get_nickname_email_sql = "select name,email from ".TABLE_PREFIX."users where account='".$username."'";
                    $rs = $db->execute($get_nickname_email_sql);
                    $row = $db->fetch_array($rs);

                    $email = $row['email'];
                    $nickname = $row['name'];
                ?>

                <div id="submit_set_right">
                    <label for="admin_pass">账号：</label><input type="text" name="admin_pass" value="<?php echo $username?>" disabled/><br/>
                    <label for="nickname">昵称：</label><input type="text" name="nickname" value="<?php echo $nickname?>"/><br/>
                    <label for="email">邮箱：</label><input type="text" name="email" value="<?php echo $email?>"/><br/>
                    <input type="submit" id="sbutton" name="Submit" value="　确认修改　">
                    <input name="ac" type="hidden" id="ac" value="modify">
                </div>
                <div class="clear"></div>
            </form>
        <?php } else { ?>
            <div id="alertmsg">
                <?php
                $username = $_SESSION['username'];
                $current_nickname = $_POST['nickname'];
                $current_email = $_POST['email'];
                if($current_email!=$email or $current_nickname!=$nickname){
                    $_SESSION['nickname'] = $current_nickname;
                    $update_sql = "update mb_users set name='".$current_nickname."',email='".$current_email."' where account='".$username."'";
                    $db->execute($update_sql);
                    echo "<br><a href=" . $pageUrl . ">修改成功！如果浏览器没有自动返回，请点击此处返回</a>";
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