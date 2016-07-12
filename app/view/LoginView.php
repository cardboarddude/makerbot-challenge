<section class="container">
    <div class="login">
      <h1>Login</h1>
      <form method="post" action="?action=login">
        <p><input type="text" name="username_or_email" value="" placeholder="Username or Email" autocomplete="off"></p>
        <p><input type="password" name="password" value="" placeholder="Password" autocomplete="off"></p>
        <p class="remember_me">
          <label>
            <input type="checkbox" name="remember_me" id="remember_me">
            Remember me on this computer
          </label>
        </p>
        <p class="submit"><input type="submit" name="commit" value="Login"></p>
      </form>
    </div>

    <div class="login-help">
      <p>New to our site? <a href="?page=register">Register now.</a>.</p>
    </div>
</section>