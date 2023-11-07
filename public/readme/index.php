<html>
<head>
<title>Laravel Coding Challenge</title>
<style>
body {
    background: #ffe;
}
.container {
    display: inline-block;
    border: 1px solid #888;
    background: #fff;
    height: 70vh;
    margin: 0 auto;
    overflow: auto;
    padding: 0;
}
.quicklinks {
    display: block;
    margin: 0.5em auto;
    text-align: center;
}
address {
    display: inline;
    color: #f00;
    font-style: normal;
    font-weight: bold;
    font-family: 'Courier New', Courier, monospace;
}
code {
    display: inline-block;
    width: auto;
    background: #e8e8c0;
    padding: 0.5em;
    margin: 0.5em;
    border: 1px solid #888;
    white-space: pre;
}
code.bash {
    color: #fff;
    background: #000;
}
code.test {
    color: #888;
    background: #ffd;
}
code.test b {
    color: #000;
    font-weight: bold;
}
code.test strong.fail {
    color: #fff;
    background: #800;
    padding: 0 1em;
}
code.test em.fail {
    font-style: normal;
    color: #f00;
} 
.added {
    color: #080;
    background: #efe;
    border: dashed 1px #080;
    margin: 1px 0;
    padding: 2px 1px;
}
.deleted {
    color: #800;
    background: #fee;
    border: dashed 1px #800;
    margin: 1px 0;
    padding: 2px 1px;
}
.optional {
    padding: 1em;
    border: 1px dashed #888;
    margin-right: 1em;
    background: #eee;
    color: #444;
}
a, a:visited { color: #00f;}
ol {
    list-style: number;
}
ol ol {
    list-style: lower-alpha;
}
li {
    font-weight: bold;
    margin-top: 1em;
}
li li {
    font-weight: normal;
    margin-top: 0.5em;
}
hr {
    display: block;
    height: 1px;
    border: 0;
    border-top: 3px solid #880;
    width: 80%;
    margin: 4em auto;
    padding: 0;
}
</style>
</head>
<body>
<h1>Laravel Coding Challenge</h1>
<h2>How this App was created</h2>
<div class="quicklinks">
Basic Setup and User Profile [ <a href="#create">Create new Site</a> ]</div>
<div class="container">
<ol>
    <li id="create">Create a new Dev Site in Homestead
        <ol>
            <li>Inside <address>Homestead.yaml</address> on host machine, add this:<br>
                <code><div class="added">  - map: drive.classaxe.local<br>    to: /home/vagrant/sites/laravel/drive/public<br>    php: "8.1"<br>    type: "apache"</div></code>
            </li>
            <li>Inside <address>/etc/hosts</address> on host machine add this:<br>
                <code><span class="added">192.168.10.10   drive.classaxe.local  # IP should match VM</span></code>
            </li>
            <li>Boot up vagrant homestead and SSH into it:<br>
                <code class="bash">cd ~/vm/Homestead<br>vagrant up<br>vagrant ssh</code>
            </li>
            <li>Create database and user for access<br>
                <code class="bash">echo "\<br>USE mysql; \<br>DROP SCHEMA IF EXISTS drive; \<br>CREATE SCHEMA drive; \<br>DROP USER if exists 'drive'@'localhost'; \<br>CREATE USER 'drive'@'localhost' IDENTIFIED BY 'd4#2!B3J?DVEmF_~cNt{-]'; \<br>GRANT ALL PRIVILEGES ON drive.* TO 'drive'@'localhost'; \<br>FLUSH PRIVILEGES" | mysql -uhomestead -psecret</code>
            </li>
            <li>Create new Laravel application inside VM:<br>
                <code class="bash">cd /home/vagrant/sites/laravel<br>composer create-project laravel/laravel="5.7.*" drive<br>cd drive</code>
            </li>
            <li>Populate <address>.env</address> with correct APP name:<br>
                <code class="bash">sudo sed -i 's/APP_NAME=Laravel/APP_NAME=Drive/' .env;</code>
            </li>
            <li>Populate <address>.env</address> with credentials for new database:<br>
                <code class="bash">sudo sed -i 's/DB_DATABASE=homestead/DB_DATABASE=drive/' .env;<br>sudo sed -i 's/DB_USERNAME=homestead/DB_USERNAME=drive/' .env;<br>sudo sed -i 's/DB_PASSWORD=/DB_PASSWORD="d4#2!B3J?DVEmF_~cNt{-]"/' .env;</code>
            </li>
            <li>Populate <address>.env</address> with SMTP credentials to allow password resets and email validation:<br>
                <code class="bash">sudo sed -i 's/MAIL_HOST=smtp/MAIL_HOST=smtp.mailtrap.io/' .env;<br>sudo sed -i 's/MAIL_PORT=1025/MAIL_PORT=2525/' .env;<br>sudo sed -i 's/MAIL_USERNAME=null/MAIL_USERNAME=3fbd3a25068e4d/' .env;<br>sudo sed -i 's/MAIL_PASSWORD=null/MAIL_PASSWORD=487a860fcb540e/' .env;</code>
            </li>
            <li>Run database migrations:<br>
                <code class="bash">php artisan migrate</code>
            </li>
            <li class="optional">
                <b>OPTIONAL:</b><br>
                <ul>
                    <li>Add the Readme file you are now viewing to <address>public/readme/index.php</address> - the file will NOT be parsed within Laravel but natively via PHP.</li>
                    <li>Modify <address>resources/views/welcome.blade.php</address> to display the current version of Laravel and PHP by inserting this new code beneath the Laravel heading:<br>
                        <code class="php">&lt;div class="content"&gt;<br>    &lt;div class="title m-b-md"&gt;<br>        Laravel<br>    &lt;/div&gt;<br><br><span class="added">    &lt;h2&gt;Laravel {{ app()->version() }} - PHP {{ PHP_VERSION }}&lt;h2&gt;</span></code>
                    </li>
                    <li>Also, provide a link to this Readme page by inserting this code at the bottom of the 'Links' list:<br>
                        <code class="php">&lt;div class="links"&gt;<br><br>    ...<br><br>    <span class="added">&lt;a href="/readme"&gt;About This Site&lt;/a&gt;</span></code>
                    </li>
                </ul>
            </li>
            <li>Run PHPUnit Testing - TWO tests should pass<br>
                <code class="bash">vendor/bin/phpunit</code>
            </li>
            <li>Commit this first version to git - <b>do this on the host container, not inside vagrant</b> so we have the SSH keys available for github.<br>
                <code class="bash">git init<br>git add .<br>git commit -m "0.0.1 Create New Site"<br>git branch -M main<br>git tag 0.0.1;<br>git remote add origin git@github.com:classaxe/drive.git<br>git push -u origin main;<br>git push --tags</code>
            </li>
        </ol>
    </li>
</ol>
</div>
<div class="quicklinks">[ <a href="/">Main Site</a> ]</div>
</body>
</html>