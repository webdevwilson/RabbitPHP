{render_element element="messages"}
<h1 class="form-heading">Create tag</h1>
<form action="/tags/tag_manager/create" method="post" enctype="multipart/form-data">

        <div class="property">
            <label for="tag_label" {if $tag && $tag->invalid('label')}class="error"{/if}>label:</label>
            <div class="field">
                {validation_messages model=tag.label}
                {input type="text" model="tag.label"}
            </div>
        </div><div class="buttons">
    <input type="submit" name="action" value="Save" />
    <input type="submit" name="action" value="Cancel" />
</div>
</form>