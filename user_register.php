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
    <title>用户注册 - <?php echo $gb_name ?></title>
    <link href="css/css.css" rel="stylesheet" type="text/css">

    <script language=JavaScript>
        function FrontPage_Form1_Validator(theForm) {
            if (theForm.user_name.value == "") {
                alert("请输入用户帐号！");
                theForm.user_name.focus();
                return (false);
            }
            if (theForm.user_pass.value == "") {
                alert("请输入用户密码！");
                theForm.user_pass.focus();
                return (false);
            }
            if(theForm.nick_name.value ==""){
                alert("请输入用户昵称");
                theForm.nick_name.focus();
                return (false);
            }
            if (theForm.nick_name.value.length<3)
            {
                alert("昵称至少应为3个字符！");
                theForm.nick_name.focus();
                return (false);
            }
            if (theForm.user_pass.value.length<6)
            {
                alert("密码至少应为6个字符！");
                theForm.user_pass.focus();
                return (false);
            }
            if(theForm.confirm_pass.value==""){
                alert("请重复密码");
                theForm.confirm_pass.focus();
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
            if(theForm.user_pass.value!=theForm.confirm_pass.value){
                alert("两次输入密码不一致");
                theForm.confirm_pass.focus();
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
                <br/>
                <div id="submit_div">
                    <label for="user_name">帐号：</label><input name="user_name" type="text" id="user_name"><br/>
                    <label for="user_pass">密码：</label><input name="user_pass" type="password" id="user_pass"><br/>
                    <label for="confirm_pass">确认密码：</label><input name="confirm_pass" type="password" id="confirm_pass"/><br/>
                    <label for="nick_name">昵称：</label><input name="nick_name" type="text" id="nick_name"/><br/>
                    <label for="email">邮箱：</label><input name = "email" type="text" id = "email"><br/>
                    <label for="unum">验证码：</label>
                    <input name="unum" type="text" id="unum" size="10">* <img src="include/randnum.php?id=-1"
                                                                              title="点击刷新" style="cursor:pointer"
                                                                              onclick=eval('this.src="include/randnum.php"')><br/>
                    <input type="submit" id="sbutton" value="确  定"/><br/><input name="action" type="hidden" value="add">
                </div>
            </form>

        <?php } else { ?>
            <div id="alertmsg">
                <?php
                if ($_POST['unum'] == $_SESSION["randValid"]) {
                    $user_name = $_POST['user_name'];
                    $user_pass = $_POST['user_pass'];
                    $nick_name = $_POST['nick_name'];
                    $confirm_pass = $_POST['confirm_pass'];
                    $email = $_POST['email'];
                    $insert_user_sql = "insert into ". TABLE_PREFIX ."users(account,name,password,email) values ('".$user_name."','".$nick_name."','".$user_pass."','".$email."')";

                    $db->execute($insert_user_sql);
                    $rs = $db->get_affected_rows();
                    if($rs==1){
                        echo "注册成功!请稍后......<br>";
                        echo "<meta http-equiv=\"refresh\" content=\"2; url=user_login.php\">";
                    }
                    elseif($rs==-1){
                        echo "<script language=\"javascript\">alert('账号不能重复，请重新输入……');history.go(-1)</script>";

//                        echo "<metsa http-equiv=\"refresh\" content=\"2; url=user_register.php\">";
                    }
                } else {
                    echo "<script language=\"javascript\">alert('验证码不正确，请修改……');history.go(-1)</script>";
                }
                ?>
            </div>
        <?php } ?>
    </div>
</div>
<?php include 'include/foot.php'; ?>
</body>
</html>

