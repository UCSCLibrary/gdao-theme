
<?php 

$title = __('Login');
echo head(
    array(
	'title'=>$title, 
	'bodyid' => 'login', 
	'bodyclass'=>'guest-user'
    ));
?>
<div id="primary">
  <h1><?php echo $title; ?> </h1>
    <form action="/users/login" method="post" enctype="application/x-www-form-urlencoded" id="login-form">
      <fieldset id="fieldset-login">
        <div class="field">
          <div class="two columns alpha" id="username-label">
            <label class="required" for="username">Username</label>
          </div>
          <div class="inputs six columns omega">
            <input type="text" value="" id="username" name="username"> 
          </div>
        </div>
        <div class="field">
          <div class="two columns alpha" id="password-label">
            <label class="required" for="password">Password</label>
          </div>
          <div class="inputs six columns omega">
            <input type="password" value="" id="password" name="password">
          </div>
        </div>
        <div class="field">
          <div class="two columns alpha" id="remember-label">
            <label class="optional" for="remember">Remember Me?</label></div>
          <div class="inputs six columns omega">
            <input type="hidden" value="0" name="remember">
            <input type="checkbox" class="checkbox" value="1" id="remember" name="remember">
          </div>
        </div>
      </fieldset>
      <div>
        <input type="submit" value="Log In" id="submit" name="submit">
      </div>
    </form>
</div>

<?php
echo foot(); 
?>
