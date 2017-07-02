<?php
error_reporting(E_ALL ^ E_WARNING);
error_reporting(E_ALL & ~E_NOTICE);
session_start();
//session_unset('confirm');
include 'include/config.php';
include 'include/para.php';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>用户登录 - <?php echo $gb_name ?></title>
    <link href="css/css.css" rel="stylesheet" type="text/css">

    <script language=JavaScript>
        function FrontPage_Form1_Validator(theForm) {
            if (theForm.admin_user.value == "") {
                alert("请输入用户帐号！");
                theForm.admin_user.focus();
                return (false);
            }
            if (theForm.admin_pass.value == "") {
                alert("请输入用户密码！");
                theForm.admin_pass.focus();
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
                    <label for="admin_user">帐号：</label><input name="admin_user" type="text" id="admin_user"><br/>
                    <label for="admin_pass">密码：</label><input name="admin_pass" type="password" id="admin_pass"><a href="reset_passwd.php"> 忘记密码</a><br/>
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
                    $admin_user = $_POST['admin_user'];
                    //$admin_pass=md5($_POST['admin_pass']);
                    $admin_pass = $_POST['admin_pass'];
                    $rs = $db->execute("select account,password,role,name from " . TABLE_PREFIX . "users where account='" . $admin_user . "'");
                    if ($db->num_rows($rs) != 0) {
                        //Check PASSWORD
                        ///////////////////////////////////////////////////////////
                        $row = $db->fetch_array($rs);
                        $db->free_result($rs);
                        if($row['role']==1){
                            $_SESSION['role'] = 1;
                            $_SESSION['username'] = $admin_user;
                            $_SESSION['nickname'] = $row[name];
                            echo "管理员成功登录，请稍候……<br><a href='index.php'>如果浏览器没有自动返回，请点击此处返回</a>";
                            echo "<meta http-equiv=\"refresh\" content=\"2; url=index.php\">";
                        }
                        else if($row['role']==2 and $row['password']==$admin_pass){
                            $_SESSION['role'] = 2;
                            $_SESSION['username'] = $admin_user;
                            $_SESSION['nickname'] = $row['name'];
                            echo "用户 ".$_SESSION['nickname']." 成功登录，请稍候……<br><a href='index.php'>如果浏览器没有自动返回，请点击此处返回</a>";
                            echo "<meta http-equiv=\"refresh\" content=\"2; url=index.php\">";
                        }
                        else{
                            echo "<script language=\"javascript\">alert('密码不正确！');history.go(-1)</script>";

                        }

                    } else {
                        echo "<script language=\"javascript\">alert('用户帐号不正确！');history.go(-1)</script>";
                    }
                } else {
                    echo "<script language=\"javascript\">alert('验证码不正确，请重新输入……');history.go(-1)</script>";
                }
                ?>
            </div>
        <?php } ?>
    </div>
</div>
<?php include 'include/foot.php'; ?>
</body>
</html>