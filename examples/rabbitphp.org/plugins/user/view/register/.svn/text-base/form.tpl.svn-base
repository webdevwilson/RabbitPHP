{script library="sitenow.user"}
{render_element element='messages'}
<form method='POST' action='/user/register/process'>
  <div id='user-registration-form'>
  	<div class="formfield email_address">
  	  <label for='user.email_address'>Email Address:</label>
  		{validation_messages model='user.email_address'}
  	  <div class='field'>{input type='text' model='user.email_address' onblur='UserRegistration.validateEmail(this.value)'}<span id='availability_message' class='marginleft error'></span></div>
  	</div>
  	<div class="formfield first_name">
  	  <label for='user.first_name'>First Name:</label>
  		{validation_messages model='user.first_name'}
  	  <div class='field'>{input type='text' model='user.first_name'}</div>
  	</div>
  	<div class="formfield last_name">
  	  <label for='user.last_name'>Last Name:</label>
  		{validation_messages model='user.last_name'}
  	  <div class='field'>{input type='text' model='user.last_name'}</div>
  	</div>
  	<div class="formfield address">
  		<label for='user.address1'>Address:</label>
  		{validation_messages model='user.address1'}
  	  <div class='field'>{input type='text' model='user.address1'}</div>
  		{validation_messages model='user.address2'}
  	  <div class='field'>{input type='text' model='user.address2'}</div>
  	</div>
  	<div class="formfield city">
  	  <label for='user.city'>City:</label>
  		{validation_messages model='user.city'}
  	  <div class='field'>{input type='text' model='user.city'}</div>
  	</div>
  	<div class="formfield state">
  	  <label for='user.state'>State:</label>
  		{validation_messages model='user.state'}
  	  <div class='field'>{input type='text' model='user.state'}</div>
  	</div>
  	<div class="formfield postal_code">
  	  <label for='user.postal_code'>Postal Code:</label>
  		{validation_messages model='user.postal_code'}
  	  <div class='field'>{input type='text' model='user.postal_code'}</div>
  	</div>
  	<div class='buttons'><input type='submit' value='Register' /></div>
  </div>
</form>