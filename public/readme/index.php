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
Basic Setup and User Profile
    [ <a href="#create">Create new Site</a>
    | <a href="#auth">Authentication</a>
    | <a href="#enforce">Email Validation</a>
]</div>
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
            <li>Run PHPUnit Testing - <b>TWO</b> tests should pass<br>
                <code class="bash">vendor/bin/phpunit</code>
            </li>
            <li>Commit this first version to git - <b>do this on the host container, not inside vagrant</b> so we have the SSH keys available for github.<br>
                <code class="bash">git init<br>git add .<br>git commit -m "0.0.1 Create New Site"<br>git branch -M main<br>git tag 0.0.1;<br>git remote add origin git@github.com:classaxe/drive.git<br>git push -u origin main;<br>git push --tags</code>
            </li>
        </ol>
    </li>

    <hr>

    <li id="auth">Implement Authentication framework
        <ol>
            <li>Install Laravel Authentication components to provide logon, registration and edit profile:
                <code class="bash">php artisan make:auth</code>
            </li>
            <li>PHP Unit tests are about to start interacting with the database, so we need to create a second database instance for test purposes.<br>
                <code class="bash">echo "\<br>USE mysql; \<br>DROP SCHEMA IF EXISTS drive_test; \<br>CREATE SCHEMA drive_test; \<br>DROP USER if exists 'drive_test'@'localhost'; \<br>CREATE USER 'drive_test'@'localhost' IDENTIFIED BY 'JfHjWg@#gh^'; \<br>GRANT ALL PRIVILEGES ON drive_test.* TO 'drive_test'@'localhost'; \<br>FLUSH PRIVILEGES" | mysql -uhomestead -psecret</code>
            </li>
            <li>Modify the <address>phpunit.xml</address> file to include environment variables to select the new test database during testing.<br>
                To do this, add these three lines to the &lt;php&gt; block:<br>
                <code class="php">        &lt;env name="DB_DATABASE" value="drive_test" /&gt;<br>        &lt;env name="DB_USERNAME" value="drive_test" /&gt;<br>        &lt;env name="DB_PASSWORD" value="JfHjWg@#gh^" /&gt;</code>
            </li>
            <li>Add a new unit test that checks that a user may successfully register and log in:<br>
                To do this, create a new file <address>tests/Feature/RegisterTest.php</address> with this content:<br>
                <code class="php">&lt;?php
namespace Tests\Feature;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use App\User;

class RegisterTest extends TestCase
{
    /* This destroys and recreates database before testing - caution! */
    use RefreshDatabase;  // Destroys and recreates DB for testing

    /** @test */
    function logon()
    {
        $user = factory(User::class)->create([
            'name' => 'Test',
            'email' => 'test@example.com',
            'password' => bcrypt('123456'),
            'email_verified_at' => null
        ]);

        $response = $this->post('login', [
            'email' => 'test@example.com',
            'password' => '123456'
        ]);

        // Confirm redirect occured
        $response->assertRedirect('/home');

        // Confirm user is logged in
        $this->assertTrue(Auth::check());
    }

    /** @test */
    function register_and_logon()
    {
        $response = $this->post('register', [
            'name' => 'Test2',
            'email' => 'test2@example.com',
            'password' => '123456',
            'password_confirmation' => '123456'
        ]);

        // Confirm redirct occurred
        $response->assertRedirect('/home');

        // Confirm user is logged in
        $this->assertTrue(Auth::check());
    }
}</code>
            </li>
            <li>Run PHPUnit Testing - <b>FOUR</b> tests should pass<br>
                <code class="bash">vendor/bin/phpunit</code>
            </li>
            <li>Test site on host machine browser:
                <ol>
                    <li>Visit <a href="http://drive.classaxe.local" target="_blank">http://drive.classaxe.local</a></li>
                    <li>Register an account</li>
                    <li>Edit the profile</li>
                    <li>Delete the account</li>
                    <li>Signin again (fail)</li>
                    <li>Recreate the account</li>
                    <li>Sign out</li>
                    <li>Use Forgot Password with bogus email</li>
                    <li>Use Forgot Password with real email</li>
                    <li>Follow link in Mailtrap</li>
                    <li>Set new password</li>
                    <li>Log in</li>
                    <li>Log out</li>
                    <li>Try to create a new profile with existing email address</li>
                </ol>
            </li>
            <li>Commit these changes to git - <b>do this on the host container, not inside vagrant</b><br>
                <code class="bash">git add .<br>git commit -m "0.0.2 Authentication"<br>git tag 0.0.2<br>git push<br>git push --tags;</code>
            </li>
        </ol>
    </li>

    <hr>

    <li id="enforce">Enforce Email Address validation
        <ol>
            <li>Open folder <address>~/sites/homestead/laravel/drive/</address> in Visual Code or similar</li>
            <li>Edit <address>app/User.php</address></li>
            <li>If neccessary, uncomment the line which provides 'MustVerifyEmail'<br>
                <code><div class="deleted">// use Illuminate\Contracts\Auth\MustVerifyEmail;</div><div class="added">use Illuminate\Contracts\Auth\MustVerifyEmail;</div></code>
            </li>
            <li>Modify class to implement MustVerifyEmail<br>
                <code>class User extends Authenticatable <span class="added">implements MustVerifyEmail</span></code>
            </li>
            <li>Edit <address>routes/web.php</address> to have the Auth Routes manager include routes for Email Verification:<br>
                <code>Auth::routes(<span class="added">['verify' =&gt; true]</span>);</code><br>
                Also, add the <b>Verified Middleware</b> to the home route:<br>
                <code>Route::get('/home', 'HomeController@index')->name('home')<span class="added">->middleware('verified')</span>;</code><br>
            </li>
            <li>Add an additional test to the previously created file <address>tests/Feature/RegisterTest.php</address><br>
            <code class="php">&lt;?php
namespace Tests\Feature;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use App\User;
<span class="added">use Illuminate\Auth\Notifications\VerifyEmail;</span>


class RegisterTest extends TestCase
{
    /* This destroys and recreates database before testing - caution! */
    use RefreshDatabase;  // Destroys and recreates DB for testing

    /** @test */
    function logon()
    {
        $user = factory(User::class)->create([
            'name' => 'Test',
            'email' => 'test@example.com',
            'password' => bcrypt('123456'),
            'email_verified_at' => null
        ]);

        $response = $this->post('login', [
            'email' => 'test@example.com',
            'password' => '123456'
        ]);

        // Confirm redirect occured
        $response->assertRedirect('/home');

        // Confirm user is logged in
        $this->assertTrue(Auth::check());
    }

    /** @test */
    function register_and_logon()
    {
        $response = $this->post('register', [
            'name' => 'Test2',
            'email' => 'test2@example.com',
            'password' => '123456',
            'password_confirmation' => '123456'
        ]);

        // Confirm redirct occurred
        $response->assertRedirect('/home');

        // Confirm user is logged in
        $this->assertTrue(Auth::check());
    }

<div class="added">    /** @test */
    public function verify_email_validates_user(): void
    {
        // VerifyEmail extends Illuminate\Auth\Notifications\VerifyEmail in this example
        $notification = new VerifyEmail();
        $user = factory(User::class)->create([ 'email_verified_at' => null ]);
    
        // New user should not has verified their email yet
        $this->assertFalse($user->hasVerifiedEmail());
    
        $mail = $notification->toMail($user);
        $uri = $mail->actionUrl;
    
        // Simulate clicking on the validation link
        $this->actingAs($user)
            ->get($uri);
    
        // User should have verified their email
        $this->assertTrue(User::find($user->id)->hasVerifiedEmail());
    }</div>
}</code>
            </li>
            <li>Run PHPUnit Testing - <b>FIVE</b> tests should now pass.<br>
                <code class="bash">vendor/bin/phpunit</code>
            </li>
            <li>Test new policy manually
                <ul>
                    <li>Create another user in UI</li>
                    <li>Check <a href="https://mailtrap.io/" target="_blank">Mailtrap</a> for the message and click the link</li>
                    <li>Run this query to look for validated email addresses:<br>
                        <code class="bash">echo "select name, email, email_verified_at from users;"| mysql drive</code>
                    </li>
                </ul>
            </li>
            <li>Commit these changes to git - <b>do this on the host container, not inside vagrant</b><br>
                <code class="bash">git add .<br>git commit -m "0.0.3 Email Validation"<br>git tag 0.0.3<br>git push<br>git push --tags;</code>
            </li>
        </ol>
    </li>
</ol>
</div>
<div class="quicklinks">[ <a href="/">Main Site</a> ]</div>
</body>
</html>