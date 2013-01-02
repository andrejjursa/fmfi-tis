{foreach $tab->getFields() as $field}{$field_type = $field->getFieldType()}
    {include file="partials/admin_editor.editor.fields.$field_type.tpl" inline}
{/foreach}