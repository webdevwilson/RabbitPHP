<h2>User Management</h2>
<table class='domain-list'>
	<thead>
		<tr>
			<th colspan='2'>&nbsp;</th>
			<th>Email Address</th>
			<th>Name</th>
			<th>Last Login</th>
			<th>Roles</th>
		</tr>
	</thead>
	<tbody>
{foreach from=$users item='user'}
		<tr>
			<td>{link action='edit' arg1=$user.id}edit{/link}</td>
			<td>{link action='delete' arg1=$user.id}delete{/link}</td>
			<td>{$user.email_address}</td>
			<td>{$user->display_name()}</td>
			<td>{$user.last_login|date_format:'%D %I:%M %p'}</td>
			<td>{implode glue=', ' pieces=$user.roles}</td>
		</tr>
{/foreach}
	</tbody>
</table>