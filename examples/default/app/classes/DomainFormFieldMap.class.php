<?

class DomainFormFieldMap {

    static function char_field($do_name, $field_name){
        return '
        <div class="property">
            <label for="'.$do_name.'_'.$field_name.'" {if $'.$do_name.' && $'.$do_name.'->invalid(\''.$field_name.'\')}class="error"{/if}>'.$field_name.':</label>
            <div class="field">
                {validation_messages model='.$do_name.'.'.$field_name.'}
                {input type="text" model="'.$do_name.'.'.$field_name.'"}
            </div>
        </div>';
    }


    static function text_field($do_name, $field_name){
        return '
        <div class="property">
            <label for="'.$do_name.'_'.$field_name.'" {if $'.$do_name.' && $'.$do_name.'->invalid(\''.$field_name.'\')}class="error"{/if}>'.$field_name.':</label>
            <div class="field">
                {validation_messages model='.$do_name.'.'.$field_name.'}
                {input type="textarea" model="'.$do_name.'.'.$field_name.'"}
            </div>
        </div>';
    }
    static function clob_field($do_name, $field_name){return DomainFormFieldMap::text_field($do_name,$field_name);}


    static function bool_field($do_name, $field_name){
        return '
        <div class="property">
            <label for="'.$do_name.'_'.$field_name.'" {if $'.$do_name.' && $'.$do_name.'->invalid(\''.$field_name.'\')}class="error"{/if}>'.$field_name.':</label>
            <div class="field">
                {validation_messages model='.$do_name.'.'.$field_name.'}
                {input type="checkbox" model="'.$do_name.'.'.$field_name.'"}
            </div>
        </div>';
    }
    static function boolean_field($do_name, $field_name){return DomainFormFieldMap::bool_field($do_name,$field_name);}
    static function bit_field($do_name, $field_name){return DomainFormFieldMap::bool_field($do_name,$field_name);}



    static function date_field($do_name, $field_name){
        return '
        <div class="property">
            <label for="'.$do_name.'_'.$field_name.'" {if $'.$do_name.' && $'.$do_name.'->invalid(\''.$field_name.'\')}class="error"{/if}>'.$field_name.':</label>
            <div class="field">
                {validation_messages model='.$do_name.'.'.$field_name.'}
                {input type="date" model="'.$do_name.'.'.$field_name.'"}
            </div>
        </div>';
    }

    static function datetime_field($do_name, $field_name){
        return '
        <div class="property">
            <label for="'.$do_name.'_'.$field_name.'" {if $'.$do_name.' && $'.$do_name.'->invalid(\''.$field_name.'\')}class="error"{/if}>'.$field_name.':</label>
            <div class="field">
                {validation_messages model='.$do_name.'.'.$field_name.'}
                {input type="text" model="'.$do_name.'.'.$field_name.'"}
            </div>
        </div>';
    }

    static function time_field($do_name, $field_name){
        return '
        <div class="property">
            <label for="'.$do_name.'_'.$field_name.'" {if $'.$do_name.' && $'.$do_name.'->invalid(\''.$field_name.'\')}class="error"{/if}>'.$field_name.':</label>
            <div class="field">
                {validation_messages model='.$do_name.'.'.$field_name.'}
                {input type="text" model="'.$do_name.'.'.$field_name.'"}
            </div>
        </div>';
    }

    
    static function int_field($do_name, $field_name){
        return '
        <div class="property">
            <label for="'.$do_name.'_'.$field_name.'" {if $'.$do_name.' && $'.$do_name.'->invalid(\''.$field_name.'\')}class="error"{/if}>'.$field_name.':</label>
            <div class="field">
                {validation_messages model='.$do_name.'.'.$field_name.'}
                {input type="text" model="'.$do_name.'.'.$field_name.'"}
            </div>
        </div>';
    }
    static function integer_field($do_name, $field_name){return DomainFormFieldMap::int_field($do_name,$field_name);}
 
    
    static function float_field($do_name, $field_name){
        return '
        <div class="property">
            <label for="'.$do_name.'_'.$field_name.'" {if $'.$do_name.' && $'.$do_name.'->invalid(\''.$field_name.'\')}class="error"{/if}>'.$field_name.':</label>
            <div class="field">
                {validation_messages model='.$do_name.'.'.$field_name.'}
                {input type="text" model="'.$do_name.'.'.$field_name.'"}
            </div>
        </div>';
    }
    static function real_field($do_name, $field_name){return DomainFormFieldMap::float_field($do_name, $field_name);}
    static function decimal_field($do_name, $field_name){return DomainFormFieldMap::float_field($do_name, $field_name);}


    static function has_many_field($do_name, $field_name){
    return '
       <div class="property">
          <label for="'.$do_name.'_'.$field_name.'" {if $'.$do_name.' && $'.$do_name.'->invalid(\''.$field_name.'\')}class="error"{/if}>'.$field_name.':</label>
          <div class="field">
            {validation_messages model='.$do_name.'.'.$field_name.'}
            {input 
                type=select 
                extra=multiple 
                multiple=true
                model='.$do_name.'.'.$field_name.'
                options=$related_objects.'.$field_name.'
            }
          </div>
      </div>
    ';
    }


    static function has_one_field($do_name, $field_name){
    return '
       <div class="property">
          <label for="'.$do_name.'_'.$field_name.'" {if $'.$do_name.' && $'.$do_name.'->invalid(\''.$field_name.'\')}class="error"{/if}>'.$field_name.':</label>
          <div class="field">
            {validation_messages model='.$do_name.'.'.$field_name.'}
            {input 
                type=select 
                model='.$do_name.'.'.$field_name.'
                options=$related_objects.'.$field_name.'
            }
          </div>
      </div>
    ';
    }

}
?>
