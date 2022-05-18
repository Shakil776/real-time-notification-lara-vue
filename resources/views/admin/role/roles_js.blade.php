<script>
    // role validation
    var jqForm = $('#role-form');
    if (jqForm.length) {
        jqForm.validate({
            rules: {
                'name': {
                    required: true
                }
            }
        });
    }

    // role validation update form
    var jqForm = $('#role-form-update');
    if (jqForm.length) {
        jqForm.validate({
            rules: {
                'name': {
                    required: true
                }
            }
        });
    }
    
    /**
     * Check all the permissions
    */
        $("#checkPermissionAll").click(function(){
            if($(this).is(':checked')){
                // check all the checkbox
                $('input[type=checkbox]').prop('checked', true);
            }else{
                // un check all the checkbox
                $('input[type=checkbox]').prop('checked', false);
            }
        });

        function checkPermissionByGroup(className, checkThis){
            const groupIdName = $("#"+checkThis.id);
            const classCheckBox = $('.'+className+' input');

            if(groupIdName.is(':checked')){
                    classCheckBox.prop('checked', true);
            }else{
                classCheckBox.prop('checked', false);
            }
            implementAllChecked();
        }

        function checkSinglePermission(groupClassName, groupID, countTotalPermission) {
            const classCheckbox = $('.'+groupClassName+ ' input');
            const groupIDCheckBox = $("#"+groupID);

            if($('.'+groupClassName+ ' input:checked').length == countTotalPermission){
                groupIDCheckBox.prop('checked', true);
            }else{
                groupIDCheckBox.prop('checked', false);
            }
            implementAllChecked();
        }

        function implementAllChecked() {
            const countPermissions = {{ count($all_permissions) }};
            const countPermissionGroups = {{ count($permission_groups) }};

            if($('input[type="checkbox"]:checked').length >= (countPermissions + countPermissionGroups)){
                $("#checkPermissionAll").prop('checked', true);
            }else{
                $("#checkPermissionAll").prop('checked', false);
            }
        }
</script>