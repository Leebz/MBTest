<?php
error_reporting(E_ALL ^ E_WARNING);
error_reporting(E_ALL & ~E_NOTICE);
session_start();

include 'include/config.php';
include 'include/para.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>密码重置 - <?php echo $gb_name ?></title>
    <link href="css/css.css" rel="stylesheet" type="text/css">

    <script language=JavaScript>
        function FrontPage_Form1_Validator(theForm) {
            if (theForm.user_name.value == "") {
                alert("请输入用户帐号！");
                theForm.user_name.focus();
                return (false);
            }
            if (theForm.new_passwd.value == "") {
                alert("请输入用户密码！");
                theForm.new_passwd.focus();
                return (false);
            }
            if(theForm.new_passwd.value.length<6){
                alert("密码长度应不小于6位");
                theForm.new_passwd.focus();
                return (false);
            }
            if(theForm.confirm_passwd.value==""){
                alert("请重复密码");
                theForm.confirm_passwd.focus();
                return (false);
            }
            if(theForm.email.value==""){
                alert("请输入邮箱");
                theForm.email.focus();
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
            if(theForm.new_passwd.value!=theForm.confirm_passwd.value){
                alert("两次输入密码不一致");
                return (false);
            }
            if (theForm.unum.value == "") {
                alert("请您输入验证码！");
                theForm.unum.focus();
                return (false);
            }

            return (true);
        }
    </script>
</head>
<body onload="i=0;document.getElementsByName('unum')[0].value=''">
<div id="main">
    <?php include 'include/head.php'; ?>
    <div id="submit">
        <?php if (empty($_POST['action'])) { ?>
            <form name="form1" method="post" action="<?php $_SERVER['PHP_SELF'] ?>"
                  onsubmit="return FrontPage_Form1_Validator(this)">
                <p><img src="images/i3.gif"/></p><br/>
                <?php if($_SESSION['confirm']!=1) {?>
                <div id="submit_div">
                    <label for="user_name">帐号：</label><input name="user_name" type="text" id="user_name"><br/>
                    <label for="email">绑定邮箱：</label><input name = "email" type="text" id = "email"><br/>
                    <label for="unum">验证码：</label>
                    <input name="unum" type="text" id="unum" size="10">* <img src="include/randnum.php?id=-1"
                                                                              title="点击刷新" style="cursor:pointer"
                                                                              onclick=eval('this.src="include/randnum.php"')><br/>
                    <input type="submit" id="sbutton" value="确  定"/><br/><input name="action" type="hidden" value="add">
                </div>
                <?php } elseif ($_SESSION['confirm']==1){?>
                <div id="submit_div">
                    <label for="new_passwd">新密码：</label><input name="new_passwd" type="password" id="new_passwd"><br/>
                    <label for="confirm_passwd">重复密码：</label><input name="confirm_passwd" type="password" id="confirm_passwd"/><br/>
                    <input type="submit" id="sbutton" value="确  定"/><br/><input name="action" type="hidden" value="add">
                </div>
                <?php } ?>
            </form>

        <?php } else { ?>
            <div id="alertmsg">
                <?php
                if($_SESSION['confirm']!=1){
                    if ($_POST['unum'] == $_SESSION["randValid"]) {
                        $user_name = $_POST['user_name'];
                        $email = $_POST['email'];
                        $confirm_psw_sql = "select * from ".TABLE_PREFIX."users where account='".$user_name."'and email='".$email."'";
                        $rs = $db->execute($confirm_psw_sql);
                        if($db->num_rows($rs) != 0){
                            $_SESSION['confirm'] = 1;
                            $_SESSION['username'] = $user_name;
                            echo "验证成功，请稍候……<br><a href='reset_passwd.php'>如果浏览器没有自动返回，请点击此处返回</a>";
                            echo "<meta http-equiv=\"refresh\" content=\"2; url=reset_passwd.php\">";
                        }
                        else{
                            echo "错误的邮箱<script language=\"javascript\">alert('输入的信息不正确');history.go(-1)</script>";

                        }

                    } else {
                        echo "<script language=\"javascript\">alert('验证码不正确，请重新输入……');history.go(-1)</script>";
                    }
                }
                elseif ($_SESSION['confirm']==1){
                    $user_name = $_SESSION['username'];
                    $user_pass = $_POST['new_passwd'];
                    $confirm_pass = $_POST['confirm_passwd'];
                    if($user_pass=="" or $confirm_pass==""){
                        echo "密码不能为空……<br><a href='user_login.php'>如果浏览器没有自动返回，请点击此处返回</a>";
                        echo "<meta http-equiv=\"refresh\" content=\"2; url=user_login.php\">";
                    }
                    elseif($user_pass!=$confirm_pass){
                        echo "密码不一致……<br><a href='user_login.php'>如果浏览器没有自动返回，请点击此处返回</a>";
                        echo "<meta http-equiv=\"refresh\" content=\"2; url=user_login.php\">";

                    }

                    else{
                        session_unset();
                        $modify_passwd_sql = "update mb_users set password='".$confirm_pass."' where account='".$user_name . "'";
                        $db->execute($modify_passwd_sql);
                        echo "成功修改，请稍候……<br><a href='user_login.php'>如果浏览器没有自动返回，请点击此处返回</a>";
                        echo "<meta http-equiv=\"refresh\" content=\"2; url=user_login.php\">";
                    }

                }

                ?>
            </div>
        <?php } ?>
    </div>
</div>
<?php include 'include/foot.php'; ?>
</body>
</html>

