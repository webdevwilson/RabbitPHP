<?php /* Smarty version 2.6.14, created on 2008-02-05 17:04:05
         compiled from file:/home/kerrywilson/rabbitphp.org/lib/framework/Trace.view.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'file:/home/kerrywilson/rabbitphp.org/lib/framework/Trace.view.tpl', 188, false),)), $this); ?>
<?php echo '
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
  	var backtrace = document.getElementById(id+\'_trace_message_backtrace\');
  	var lnk = document.getElementById(id+\'_trace_message_link\');
  	if( backtrace ) {
  		backtrace.style.display = ( backtrace.style.display == \'block\' ? \'none\' : \'block\' );
  	}
  	if( lnk ) {
  		lnk.innerHTML = ( backtrace.style.display == \'block\' ? \'HIDE STACK\' : \'SHOW STACK\' );
  	}
  }
  
  function toggle_trace_query_stack(id) {
  	var backtrace = document.getElementById(id+\'_trace_query_backtrace\');
  	var lnk = document.getElementById(id+\'_trace_query_stack_link\');
  	if( backtrace ) {
  		backtrace.style.display = ( backtrace.style.display == \'block\' ? \'none\' : \'block\' );
  	}
  	if( lnk ) {
  		lnk.innerHTML = ( backtrace.style.display == \'block\' ? \'HIDE STACK\' : \'SHOW STACK\' );
  	}
  }
  function toggle_trace_query_results(id) {
  	var backtrace = document.getElementById(id+\'_trace_query_results\');
  	var lnk = document.getElementById(id+\'_trace_query_results_link\');
  	if( backtrace ) {
  		backtrace.style.display = ( backtrace.style.display == \'block\' ? \'none\' : \'block\' );
  	}
  	if( lnk ) {
  		lnk.innerHTML = ( backtrace.style.display == \'block\' ? \'HIDE RESULTS\' : \'SHOW RESULTS\' );
  	}
  }
  
  function toggle_trace_included_files() {
  	var files = document.getElementById(\'trace_included_files\');
  	var lnk = document.getElementById(\'trace_included_files_link\');
  	if( files ) {
  		files.style.display = ( files.style.display == \'block\' ? \'none\' : \'block\' );
  	}
  	if( lnk ) {
  		lnk.innerHTML = ( files.style.display == \'block\' ? \'HIDE FILES\' : \'SHOW FILES\' );
  	}
  }
</script>
'; ?>

<div class="trace">
	<div id="messages">
    <h1>Messages</h1>
<?php $_from = $this->_tpl_vars['messages']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['message']):
?>
    <div class="tracemessage">
      <div class="option"><a href="javascript:toggle_trace_message(<?php echo $this->_tpl_vars['key']; ?>
);" id="<?php echo $this->_tpl_vars['key']; ?>
_trace_message_link">SHOW STACK</a></div>
  	  <div class="time"><?php echo $this->_tpl_vars['message']['time']; ?>
</div>
  	  <div class="level"><?php echo $this->_tpl_vars['message']['level']; ?>
</div>
  	  <div class="text"><?php echo $this->_tpl_vars['message']['text']; ?>
</div>
  	  <div class="backtrace" id="<?php echo $this->_tpl_vars['key']; ?>
_trace_message_backtrace" style="display: none;">
  	  	<h2>Stack Trace:</h2>
  <?php $_from = $this->_tpl_vars['message']['backtrace']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['bt'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['bt']['total'] > 0):
    $_values = array_values($_from);
    foreach ($_from as $this->_tpl_vars['call']):
        if( isset( $_values[$this->_foreach['bt']['iteration']-1] ) ) { $this->_foreach['bt']['prev'] = $_values[$this->_foreach['bt']['iteration']-1]; } else { $this->_foreach['bt']['prev'] = false; }
        if( isset( $_values[$this->_foreach['bt']['iteration']+1] ) ) { $this->_foreach['bt']['next'] = $_values[$this->_foreach['bt']['iteration']+1]; } else { $this->_foreach['bt']['next'] = false; }
        $this->_foreach['bt']['iteration']++;
?>
        <li style='list-style: none;'>
      	<?php if ($this->_tpl_vars['call']['file'] == ''): ?>Unknown File<?php else:  echo $this->_tpl_vars['call']['file'];  endif; ?>
      	<?php if ($this->_tpl_vars['call']['line'] == ''): ?>[Unknown Line]<?php else: ?>[<?php echo $this->_tpl_vars['call']['line']; ?>
]<?php endif; ?>
      	<?php if ($this->_foreach['bt']['prev']): ?>&nbsp;-&nbsp;<?php if ($this->_foreach['bt']['prev']['class'] == ''): ?>Global method <?php else:  echo $this->_foreach['bt']['prev']['class']; ?>
.<?php endif;  if ($this->_foreach['bt']['prev']['function'] == ''): ?>&nbsp;Unknown Method<?php else:  echo $this->_foreach['bt']['prev']['function']; ?>
()<?php endif;  endif; ?>
        </li>
  <?php endforeach; endif; unset($_from); ?>
  	  </div>
    </div>
<?php endforeach; endif; unset($_from); ?>
  </div>
  <div id="request">
    <h1>View Objects</h1>
<?php $_from = $this->_tpl_vars['view_objects']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['name'] => $this->_tpl_vars['value']):
?>
    <div class="request_attribute">
    	<div class="option">&nbsp;</div>
      <div class="name"><?php echo $this->_tpl_vars['name']; ?>
</div>
      <div class="value">
      	<?php if (is_object ( $this->_tpl_vars['value'] )): ?>
      	  <?php  echo get_class($this->_tpl_vars['value']) ?> Object
      	<?php else: ?>
      	  <?php  echo $this->_tpl_vars['value']; ?>
      	<?php endif; ?>
      </div>
      <div class="clear">&nbsp;</div>
    </div>
<?php endforeach; endif; unset($_from); ?>
  </div>
  <div id="session">
    <h1>Session Attributes</h1>
<?php $_from = $this->_tpl_vars['session']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['name'] => $this->_tpl_vars['value']):
?>
    <div class="session_attribute">
    	<div class="option">&nbsp;</div>
      <div class="name"><?php echo $this->_tpl_vars['name']; ?>
</div>
      <div class="value">
      	<?php if (is_object ( $this->_tpl_vars['value'] )): ?>
      	  <?php  echo get_class($this->_tpl_vars['value']) ?> Object
      	<?php elseif (get_class ( $this->_tpl_vars['value'] ) == '__PHP_Incomplete_Class'): ?>
      	  <?php  echo "Domain Object"; ?>
      	<?php else: ?>
      	  <?php  var_dump( $this->_tpl_vars['value'] ); ?>
      	<?php endif; ?>
      </div>
      <div class="clear">&nbsp;</div>
    </div>
<?php endforeach; endif; unset($_from); ?>
  </div>
  <div id="cookies">
    <h1>Cookies</h1>
<?php $_from = $this->_tpl_vars['cookie']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['name'] => $this->_tpl_vars['value']):
?>
    <div class="cookie">
    	<div class="option">&nbsp;</div>
      <div class="name"><?php echo $this->_tpl_vars['name']; ?>
</div>
      <div class="value"><?php  var_export($this->_tpl_vars['value']) ?></div>
      <div class="clear">&nbsp;</div>
    </div>
<?php endforeach; endif; unset($_from); ?>
  </div>
  <div id="queries">
    <h1>Database Queries</h1>
<?php $_from = $this->_tpl_vars['queries']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['query']):
?>
    <div class="query">
      <div class="option">
      	<a href="javascript:toggle_trace_query_stack(<?php echo $this->_tpl_vars['key']; ?>
);" id="<?php echo $this->_tpl_vars['key']; ?>
_trace_query_stack_link">SHOW STACK</a>&nbsp;
      	<a href="javascript:toggle_trace_query_results(<?php echo $this->_tpl_vars['key']; ?>
);" id="<?php echo $this->_tpl_vars['key']; ?>
_trace_query_results_link">SHOW RESULTS</a>&nbsp;
      </div>
  	  <div class="time"><?php echo $this->_tpl_vars['query']['time']; ?>
</div>
  	  <div class="type"><?php echo $this->_tpl_vars['query']['type']; ?>
</div>
  	  <div class="sql"><?php echo ((is_array($_tmp=$this->_tpl_vars['query']['sql'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</div>
  	  <div class="backtrace" id="<?php echo $this->_tpl_vars['key']; ?>
_trace_query_backtrace" style="display: none;">
  	  	<h2>Stack Trace:</h2>
  <?php $_from = $this->_tpl_vars['query']['backtrace']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['bt'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['bt']['total'] > 0):
    $_values = array_values($_from);
    foreach ($_from as $this->_tpl_vars['call']):
        if( isset( $_values[$this->_foreach['bt']['iteration']-1] ) ) { $this->_foreach['bt']['prev'] = $_values[$this->_foreach['bt']['iteration']-1]; } else { $this->_foreach['bt']['prev'] = false; }
        if( isset( $_values[$this->_foreach['bt']['iteration']+1] ) ) { $this->_foreach['bt']['next'] = $_values[$this->_foreach['bt']['iteration']+1]; } else { $this->_foreach['bt']['next'] = false; }
        $this->_foreach['bt']['iteration']++;
?>
        <li style='list-style: none;'>
      	<?php if ($this->_tpl_vars['call']['file'] == ''): ?>Unknown File<?php else:  echo $this->_tpl_vars['call']['file'];  endif; ?>
      	<?php if ($this->_tpl_vars['call']['line'] == ''): ?>[Unknown Line]<?php else: ?>[<?php echo $this->_tpl_vars['call']['line']; ?>
]<?php endif; ?>
      	<?php if ($this->_foreach['bt']['prev']): ?>&nbsp;-&nbsp;<?php if ($this->_foreach['bt']['prev']['class'] == ''): ?>Global method <?php else:  echo $this->_foreach['bt']['prev']['class']; ?>
.<?php endif;  if ($this->_foreach['bt']['prev']['function'] == ''): ?>&nbsp;Unknown Method<?php else:  echo $this->_foreach['bt']['prev']['function']; ?>
()<?php endif;  endif; ?>
        </li>
  <?php endforeach; endif; unset($_from); ?>
  	  </div>
  	  <div class="results" id="<?php echo $this->_tpl_vars['key']; ?>
_trace_query_results" style="display: none;">
  	  	<h2>Results:</h2>
  <?php if (count ( $this->_tpl_vars['query']['results'] ) == 0): ?><p class='empty'>Empty Resultset</p><?php endif; ?>
        <table cellpadding="2" cellspacing="1" border="0" style="width: 100%;">
          <tr>
  <?php $_from = $this->_tpl_vars['query']['result_columns']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['column']):
?>
            <th><?php echo $this->_tpl_vars['column']; ?>
</th>      
  <?php endforeach; endif; unset($_from); ?>
          </tr>
  <?php $_from = $this->_tpl_vars['query']['results']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['result']):
?>
          <tr>
    <?php $_from = $this->_tpl_vars['query']['result_columns']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['column']):
?>
            <td><?php echo ((is_array($_tmp=$this->_tpl_vars['result'][$this->_tpl_vars['column']])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</td>
    <?php endforeach; endif; unset($_from); ?>
          </tr>
  <?php endforeach; endif; unset($_from); ?>
        </table>
      </div>
    </div>
<?php endforeach; endif; unset($_from); ?>
  </div>
  <div id="performance">
    <h1>Performance</h1>
    <div class="item">
    	<div class="option"><a href="javascript: toggle_trace_included_files();">SHOW FILES</a></div>
    	<div class="name">Number of included files:</div>
    	<div class="value"><?php  echo count($this->_tpl_vars['included_files']) ?></div>
    	<div class="clear"></div>
      <div id="trace_included_files" style="display: none">
<?php $_from = $this->_tpl_vars['included_files']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['file']):
?>
    	  <div class="included_file"><?php echo $this->_tpl_vars['file']; ?>
</div>
<?php endforeach; endif; unset($_from); ?>
      </div>  
    </div>
    <div class="item">
    	<div class="option">&nbsp;</div>
    	<div class="name">Page parse time:</div>
    	<div class="value"><?php echo $this->_tpl_vars['parse_time']; ?>
</div>
    	<div class="clear"></div>
    </div>
    <div class="item">
    	<div class="option">&nbsp;</div>
    	<div class="name">Number of Database Queries:</div>
    	<div class="value"><?php  echo count($this->_tpl_vars['queries']) ?></div>
    	<div class="clear"></div>
    </div>
  </div>
</div>