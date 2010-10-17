{*
/**
 * View file for confirm message
 * @package RabbitPHP
 * @subpackage Framework
 * @author Kerry R Wilson <kerry@rabbitphp.org>
 * @version 0.1
 */
*}
{if not isset($confirm_text)}
  {assign var='confirm_text' value='Confirm'}
{/if}
{if not isset($cancel_text)}
  {assign var='cancel_text' value='Cancel'}
{/if}
<form action="{$controller.url}" method="POST">
	<h1 class="confirmation">{$message}</h1>
	{foreach from=$params key='name' item='value'}
	<input type="hidden" name="{$name}" value="{$value}"/>
	{/foreach}
	{if count($options) > 0 }
	  {foreach from=$options item='option'}
	  <input type="submit" name="{$option.name}" value="{$option.text}"/>&nbsp;
	  {/foreach}
	{else}
	<input type="submit" name="confirm" value="{$confirm_text}"/>&nbsp;<input type="submit" name="cancel" value="{$cancel_text}"/>
  {/if}
</form>
