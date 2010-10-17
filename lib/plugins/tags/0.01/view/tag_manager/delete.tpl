
{render_element element="messages"}
<h1 class="form-heading">Delete tag?</h1>
<form action="/tags/tag_manager/delete/{$tag->oid}" method="post" enctype="multipart/form-data">
<table>

  <tr>
    <td><b>created</b></td>
    <td>{$tag.created|nl2br}</td>
  </tr>

  <tr>
    <td><b>updated</b></td>
    <td>{$tag.updated|nl2br}</td>
  </tr>

  <tr>
    <td><b>label</b></td>
    <td>{$tag.label|nl2br}</td>
  </tr>

</table>

<br><br>
<div class="buttons">
    <input type="submit" name="action" value="Delete" />
    <input type="submit" name="action" value="Cancel" />
</div>
</form>
<br>
