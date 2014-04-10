在Heroku上运行Apache+PHP5.3+ZendGuardLoader
<br>
<br>
安装方法：
<br>
<blockquote formatblock="1" style="margin: 0.8em 0px 0.8em 2em; padding: 0px 0px 0px 0.7em; border-left: 2px solid rgb(221, 221, 221);">
    git clone https://github.com/puteulanus/heroku-php-zend.git php-zend
    <br>
    cd php-zend
    <br>
    heroku create --stack cedar 应用名
    <br>
    git push heroku master:master
    <br>
</blockquote>
<br>
文件、目录及作用：
<br>
<blockquote formatblock="1" style="margin: 0.8em 0px 0.8em 2em; padding: 0px 0px 0px 0.7em; border-left: 2px solid rgb(221, 221, 221);">
    <span class="css-truncate css-truncate-target">
        <span class="js-directory-link">
            Procfile
        </span>
    </span>
    &nbsp;&nbsp;&nbsp; ——规定web启动脚本位置
    <br>
    <span class="css-truncate css-truncate-target">
        <span class="js-directory-link">
            conf
        </span>
    </span>
    &nbsp;&nbsp;&nbsp; ——Apache配置文件
    <br>
    <span class="css-truncate css-truncate-target">
        <span class="js-directory-link">
            libs
        </span>
    </span>
    &nbsp;&nbsp;&nbsp; ——扩展存放目录
    <br>
    <span class="css-truncate css-truncate-target">
        <span class="js-directory-link">
            php.ini
        </span>
    </span>
    &nbsp;&nbsp;&nbsp; ——PHP配置文件
    <br>
    <span class="css-truncate css-truncate-target">
        <span class="js-directory-link">
            index.php
        </span>
    </span>
    &nbsp;&nbsp;&nbsp; ——空文件，使应用被识别为PHP
    <br>
    <span class="css-truncate css-truncate-target">
        <span class="js-directory-link">
            public
        </span>
    </span>
    &nbsp;&nbsp;&nbsp; ——网站根目录
    <br>
</blockquote>
<br>
<br>
