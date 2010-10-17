{render_element element='messages'}
<form method='POST' action='/user/login/process'>
  <div class='login-box'>
    <div class='label email'>Email Address:</div>
    <div class='field email'>{input type='text' model='user.email_address'}</div>
    <div class='label password'>Password:</div>
    <div class='field password'>{input type='password' name='password'}</div>
    <div class='button submit'>
    	<input type='submit' value='Login'/>
    </div>
    <div class='options'>
    	{link controller='register' action='new_user'}Would you like to register?{/link}
    	{link action='forgot_password'}Did you forget your password?{/link}
    </div>
  </div>
</form>