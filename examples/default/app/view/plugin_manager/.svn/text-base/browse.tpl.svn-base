<h3>Plugins</h3>

<table cellpadding="5px" style="border-style: solid; border-width: 1px; border-color: black; ">
    <tr style="border-style-bottom: solid">
        <td><b>Plugin</b></td>
        <td><b>Current Version</b></td>
        <td><b>Available Versions</b></td>
    </tr>

    {foreach from=$all_plugins key=plugin_name item=plugin}
    {if $plugin.is_installed=='true'}
    <tr style="background-color: #eeeeee">
    {else}
    <tr>
    {/if}

        <td>{$plugin_name}</td>
        <td>{$plugin.installed_version}</td>
        <td>
        {foreach from=$plugin.old_versions key=version item=description}
            <a  style="border-bottom: 1px dashed rgb(0, 0, 255); cursor: help; text-decoration: none;" title="{$description}">{$version}</a>&nbsp;
        {/foreach}
        {foreach from=$plugin.installable_versions key=version item=description}
            <a href="/plugin_manager/install/{$plugin_name}/{$version}" title="{$description}">{$version}</a>&nbsp;
        {/foreach}
        </td>
    </tr>
    {/foreach}
</table>
