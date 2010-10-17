{script library="sitenow.user"}
{render_element element='messages'}
<form method='POST' action='/user/change_password/update'>
	<div id="user-change-password-form">
		<div class="formfield current_password">
  	  <label for='current_password'>Current Password:</label>
  		<div class='field'>{input type='password' name='current_password'}</div>
  	</div>
		<div class="formfield new_password">
  	  <label for='new_password'>New Password:</label>
  		<div class='field'>{input type='password' name='new_password'}</div>
  	</div>
		<div class="formfield confirm_password">
  	  <label for='confirm_password'>Confirm Password:</label>
  		<div class='field'>{input type='password' name='confirm_password'}</div>
  	</div>
  	<div class='buttons'><input type='submit' value='Update' /></div>
  	{input type='hidden' model='token.token'}
	</div>
</form>