<div id="top">
    <!--logo-->
    <div id="logoarea"><a href="index.php"><img src="<?php echo $gb_logo ?>" alt="<?php echo $gb_name ?> - 留言本"></a>
    </div>
    <!--菜单-->
    <div id="menu">
        <ul>
            <li><a href="index.php"><img src="images/i2.gif"><br>浏览留言</a></li>
            <?php if ($_SESSION['role']!=1 and $_SESSION['role']!=2) { ?>
                <li><a href="javascript:if(confirm('登录后才能留言~'))location='user_login.php'"><img src="images/i1.gif"><br>签写留言</a></li>
                <li><a href="user_login.php"><img src="images/i3.gif"><br>用户登录</a></li>
                <li><a href="user_register.php"><img src="images/i3.gif"><br>用户注册</a></li>
                <?php } ?>
            <?php if ($_SESSION['role']==1 or $_SESSION['role']==2) { ?>
                <li><a href="add_message.php"><img src="images/i1.gif"><br>签写留言</a></li>
                <li><a href="user_modify_passwd.php"><img src="images/admin_set.gif"><br>设置</a>
                <li><a href="javascript:if(confirm('您确认要退出吗?'))location='admin_action.php?ac=logout'">
                        <img src="images/i3.gif"><br>退出登录</a></li>
                <li id="welcome_area">
                    <?php echo "<br>欢迎用户!<br>".$_SESSION['nickname']?>
                </li>
                <?php } ?>

        </ul>
    </div>
</div>