{*
  Trace view
  
  Smarty variables:
  messages - Messages logged
  queries - Queries executed
  included_files - Files that have been included
  parse_time - Length in seconds of the parsing
  request - The Request Object
  response - The Response Object
  
*}
{literal}
<style>
 div.trace { background-color: #eee; font-family: arial; font-size: .9em; margin-top: 50px; }
 div.trace h1 { padding: 3px; margin: 2px; font-size: 1.4em; }
 div.trace h2 { font-size: 1.2em; }
 
 div.trace div.tracemessage { background-color: #f6f6f6; margin-bottom: 2px; padding: 3px; }
 div.trace div.tracemessage div.option{ float: left; width: 7em; }
 div.trace div.tracemessage div.time  { float: left; width: 9em; }
 div.trace div.tracemessage div.level { float: left; width: 6em; }
 div.trace div.tracemessage div.text  {  }
 
 div.trace div.request_attribute { background-color: #f6f6f6; margin-bottom: 2px; padding: 3px; }
 div.trace div.request_attribute div.option { float: left; width: 1em; }
 div.trace div.request_attribute div.name { float: left; width: 13em; }
 div.trace div.request_attribute div.value{ float: left; }

 div.trace div.session_attribute { background-color: #f6f6f6; margin-bottom: 2px; padding: 3px; }
 div.trace div.session_attribute div.option { float: left; width: 1em; }
 div.trace div.session_attribute div.name { float: left; width: 13em; }
 div.trace div.session_attribute div.value{ float: left; }

 div.trace div.cookie { background-color: #f6f6f6; margin-bottom: 2px; padding: 3px; }
 div.trace div.cookie div.option { float: left; width: 1em; }
 div.trace div.cookie div.name { float: left; width: 13em; }
 div.trace div.cookie div.value{ float: left; }

 div.trace div.response_attribute { background-color: #f6f6f6; margin-bottom: 2px; padding: 3px; }
 div.trace div.response_attribute div.option { float: left; width: 1em; }
 div.trace div.response_attribute div.name { float: left; width: 13em; }
 div.trace div.response_attribute div.value{ float: left; }
 
 div.trace div.query { background-color: #f6f6f6; margin-bottom: 2px; padding: 3px; }
 div.trace div.query div.option{ float: left; width: 15em; }
 div.trace div.query div.time  { float: left; width: 9em; }
 div.trace div.query div.type { float: left; width: 5em; }
 div.trace div.query div.text  {  }
 
 div.trace div.query div.results { max-height: 250px; overflow: auto; }
 div.trace div.query div.results p.empty { font-weight: bold; margin: 5px; text-align: center;}
 div.trace div.query div.results table { font-size: .9em;  background-color: #ccc;}
 div.trace div.query div.results tr { background-color: #f6f6f6; }
 div.trace div.query div.results th { font-weight: bold; background-color: #e9e9e9; }
 
 div.trace div.item { width: 100%; background-color: #f6f6f6; margin-bottom: 2px; padding: 3px;}
 div.trace div.item div.option { float: left; width: 7em; }
 div.trace div.item div.name   { float: left; width: 15em; }
 div.trace div.item div.value  { float: left; width: 15em; }
 div.trace div.item div.clear  { float: none; clear: both; width: 15em; }

</style>
<script language="javascript">
  function toggle_trace_message(id) { 
  	var backtrace = document.getElementById(id+'_trace_message_backtrace');
  	var lnk = document.getElementById(id+'_trace_message_link');
  	if( backtrace ) {
  		backtrace.style.display = ( backtrace.style.display == 'block' ? 'none' : 'block' );
  	}
  	if( lnk ) {
  		lnk.innerHTML = ( backtrace.style.display == 'block' ? 'HIDE STACK' : 'SHOW STACK' );
  	}
  }
  
  function toggle_trace_query_stack(id) {
  	var backtrace = document.getElementById(id+'_trace_query_backtrace');
  	var lnk = document.getElementById(id+'_trace_query_stack_link');
  	if( backtrace ) {
  		backtrace.style.display = ( backtrace.style.display == 'block' ? 'none' : 'block' );
  	}
  	if( lnk ) {
  		lnk.innerHTML = ( backtrace.style.display == 'block' ? 'HIDE STACK' : 'SHOW STACK' );
  	}
  }
  function toggle_trace_query_results(id) {
  	var backtrace = document.getElementById(id+'_trace_query_results');
  	var lnk = document.getElementById(id+'_trace_query_results_link');
  	if( backtrace ) {
  		backtrace.style.display = ( backtrace.style.display == 'block' ? 'none' : 'block' );
  	}
  	if( lnk ) {
  		lnk.innerHTML = ( backtrace.style.display == 'block' ? 'HIDE RESULTS' : 'SHOW RESULTS' );
  	}
  }
  
  function toggle_trace_included_files() {
  	var files = document.getElementById('trace_included_files');
  	var lnk = document.getElementById('trace_included_files_link');
  	if( files ) {
  		files.style.display = ( files.style.display == 'block' ? 'none' : 'block' );
  	}
  	if( lnk ) {
  		lnk.innerHTML = ( files.style.display == 'block' ? 'HIDE FILES' : 'SHOW FILES' );
  	}
  }
</script>
{/literal}
<div class="trace">
	<div id="messages">
    <h1>Messages</h1>
{foreach from=$messages key='key' item='message'}
    <div class="tracemessage">
      <div class="option"><a href="javascript:toggle_trace_message({$key});" id="{$key}_trace_message_link">SHOW STACK</a></div>
  	  <div class="time">{$message.time}</div>
  	  <div class="level">{$message.level}</div>
  	  <div class="text">{$message.text}</div>
  	  <div class="backtrace" id="{$key}_trace_message_backtrace" style="display: none;">
  	  	<h2>Stack Trace:</h2>
  {foreach from=$message.backtrace item='call' name='bt'}
        <li style='list-style: none;'>
      	{if $call.file == ''}Unknown File{else}{$call.file}{/if}
      	{if $call.line == ''}[Unknown Line]{else}[{$call.line}]{/if}
      	{if $smarty.foreach.bt.prev}&nbsp;-&nbsp;{if $smarty.foreach.bt.prev.class == ''}Global method {else}{$smarty.foreach.bt.prev.class}.{/if}{if $smarty.foreach.bt.prev.function == ''}&nbsp;Unknown Method{else}{$smarty.foreach.bt.prev.function}(){/if}{/if}
        </li>
  {/foreach}
  	  </div>
    </div>
{/foreach}
  </div>
  <div id="request">
    <h1>View Objects</h1>
{foreach from=$view_objects key='name' item='value'}
    <div class="request_attribute">
    	<div class="option">&nbsp;</div>
      <div class="name">{$name}</div>
      <div class="value">
      	{if is_object($value)}
      	  {php} echo get_class($this->_tpl_vars['value']){/php} Object
      	{else}
      	  {php} echo $this->_tpl_vars['value'];{/php}
      	{/if}
      </div>
      <div class="clear">&nbsp;</div>
    </div>
{/foreach}
  </div>
  <div id="session">
    <h1>Session Attributes</h1>
{foreach from=$session key='name' item='value'}
    <div class="session_attribute">
    	<div class="option">&nbsp;</div>
      <div class="name">{$name}</div>
      <div class="value">
      	{if is_object($value)}
      	  {php} echo get_class($this->_tpl_vars['value']){/php} Object
      	{elseif get_class($value) == '__PHP_Incomplete_Class'}
      	  {php} echo "Domain Object";{/php}
      	{else}
      	  {php} var_dump( $this->_tpl_vars['value'] );{/php}
      	{/if}
      </div>
      <div class="clear">&nbsp;</div>
    </div>
{/foreach}
  </div>
  <div id="cookies">
    <h1>Cookies</h1>
{foreach from=$cookie key='name' item='value'}
    <div class="cookie">
    	<div class="option">&nbsp;</div>
      <div class="name">{$name}</div>
      <div class="value">{php} var_export($this->_tpl_vars['value']){/php}</div>
      <div class="clear">&nbsp;</div>
    </div>
{/foreach}
  </div>
  <div id="queries">
    <h1>Database Queries</h1>
{foreach from=$queries key='key' item='query'}
    <div class="query">
      <div class="option">
      	<a href="javascript:toggle_trace_query_stack({$key});" id="{$key}_trace_query_stack_link">SHOW STACK</a>&nbsp;
      	<a href="javascript:toggle_trace_query_results({$key});" id="{$key}_trace_query_results_link">SHOW RESULTS</a>&nbsp;
      </div>
  	  <div class="time">{$query.time}</div>
  	  <div class="type">{$query.type}</div>
  	  <div class="sql">{$query.sql|escape:html}</div>
  	  <div class="backtrace" id="{$key}_trace_query_backtrace" style="display: none;">
  	  	<h2>Stack Trace:</h2>
  {foreach from=$query.backtrace item='call' name='bt'}
        <li style='list-style: none;'>
      	{if $call.file == ''}Unknown File{else}{$call.file}{/if}
      	{if $call.line == ''}[Unknown Line]{else}[{$call.line}]{/if}
      	{if $smarty.foreach.bt.prev}&nbsp;-&nbsp;{if $smarty.foreach.bt.prev.class == ''}Global method {else}{$smarty.foreach.bt.prev.class}.{/if}{if $smarty.foreach.bt.prev.function == ''}&nbsp;Unknown Method{else}{$smarty.foreach.bt.prev.function}(){/if}{/if}
        </li>
  {/foreach}
  	  </div>
  	  <div class="results" id="{$key}_trace_query_results" style="display: none;">
  	  	<h2>Results:</h2>
  {if count($query.results) == 0 }<p class='empty'>Empty Resultset</p>{/if}
        <table cellpadding="2" cellspacing="1" border="0" style="width: 100%;">
          <tr>
  {foreach from=$query.result_columns item='column'}
            <th>{$column}</th>      
  {/foreach}
          </tr>
  {foreach from=$query.results item='result'}
          <tr>
    {foreach from=$query.result_columns item='column'}
            <td>{$result.$column|escape:html}</td>
    {/foreach}
          </tr>
  {/foreach}
        </table>
      </div>
    </div>
{/foreach}
  </div>
  <div id="performance">
    <h1>Performance</h1>
    <div class="item">
    	<div class="option"><a href="javascript: toggle_trace_included_files();">SHOW FILES</a></div>
    	<div class="name">Number of included files:</div>
    	<div class="value">{php} echo count($this->_tpl_vars['included_files']){/php}</div>
    	<div class="clear"></div>
      <div id="trace_included_files" style="display: none">
{foreach from=$included_files item='file'}
    	  <div class="included_file">{$file}</div>
{/foreach}
      </div>  
    </div>
    <div class="item">
    	<div class="option">&nbsp;</div>
    	<div class="name">Page parse time:</div>
    	<div class="value">{$parse_time}</div>
    	<div class="clear"></div>
    </div>
    <div class="item">
    	<div class="option">&nbsp;</div>
    	<div class="name">Number of Database Queries:</div>
    	<div class="value">{php} echo count($this->_tpl_vars['queries']){/php}</div>
    	<div class="clear"></div>
    </div>
  </div>
</div>