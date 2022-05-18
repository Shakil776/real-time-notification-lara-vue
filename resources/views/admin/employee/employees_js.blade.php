<script>
    // datatable init
    if ($('#employeeTable').length) {
        $('#employeeTable').DataTable({
            responsive: true,
            processing: true,


            "dom": '<"top"<"left-col"l><"center-col"B><"right-col"f>>rtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fas fa-file-excel"></i> Excel',
                    title : function() {
                        return "Employee List";
                    },
                    titleAttr: 'Excel',
                    exportOptions: {
                        columns: [0,1,3,4,5,6,7,8,9]
                    },
                    className: 'btn-primary'
                },
                {
                    extend: 'csvHtml5',
                    text: '<i class="fas fa-file-csv"></i> CSV',
                    title : function() {
                        return "Employee List";
                    },
                    titleAttr: 'CSV',
                    exportOptions: {
                        columns: [0,1,3,4,5,6,7,8,9]
                    },
                    className: 'btn-primary'
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="fas fa-file-pdf"></i> PDF',
                    title : function() {
                        return "Employee List";
                    },
                    orientation : 'landscape',
                    pageSize : 'LEGAL',
                    titleAttr : 'PDF',
                    exportOptions: {
                        columns: [0,1,3,4,5,6,7,8,9]
                    },
                    className: 'btn-primary'
                },
                {
                    extend: 'print',
                    text: '<i class="fas fa-print"></i> Print',
                    title : function() {
                        return "Employee List";
                    },
                    titleAttr: 'Print',
                    exportOptions: {
                        columns: [0,1,3,4,5,6,7,8,9]
                    },
                    className: 'btn-primary'
                }
    
            ]

        });
        
    }

    // dob Flatpickr
    var basicPickr = $('.flatpickr-basic');
    if (basicPickr.length) {
        basicPickr.flatpickr();
    }
    
    // employee create form validation
    var jqForm = $('#employee-create-form');
    if (jqForm.length) {
        jqForm.validate({
            rules: {
                'name': {
                    required: true
                },
                'email': {
                    required: true,
                    email: true
                },
                'mobile': {
                    required: true
                },
                'dob': {
                    required: true
                },'position': {
                    required: true
                },'hire_date': {
                    required: true
                },'department_id': {
                    required: true
                },
                'shift_timetable_id': {
                    required: true
                },'salary': {
                    required: true
                },'device_emp_id': {
                    required: true
                },'gender': {
                    required: true
                },
            }
        });
    }

    // employee update form validation
    var jqForm = $('#employee-update-form');
    if (jqForm.length) {
        jqForm.validate({
            rules: {
                'name': {
                    required: true
                },
                'email': {
                    required: true,
                    email: true
                },
                'mobile': {
                    required: true
                },
                'dob': {
                    required: true
                },'position': {
                    required: true
                },'hire_date': {
                    required: true
                },'department_id': {
                    required: true
                },
                'shift_timetable_id': {
                    required: true
                },'salary': {
                    required: true
                },'device_emp_id': {
                    required: true
                },'gender': {
                    required: true
                },
            }
        });
    }

    // delete Employee
    $(document).on("click", ".deleteEmployee", function(e) {
        e.preventDefault();

        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then(result => {
            if (result.isConfirmed) {
                $("#employeeDeleteForm").submit();
            }
        });
    });

    // change employee status
    $(document).on("click", ".changeEmployeeStatus", function(){
        var status = $(this).children("i").attr("status");
        var employee_id = $(this).attr("employee_id");
        
        $.ajax({
            type: 'POST',
            url: '/employee-status',
            data: {status:status, employee_id:employee_id},
            success: function(resp){
                if(resp['status'] == 0){
                    $("#employee-"+employee_id).html("<i class='fas fa-toggle-off' status='Inactive'></i>");
                } else if(resp['status'] == 1){
                    $("#employee-"+employee_id).html("<i class='fas fa-toggle-on' status='Active'></i>");
                }
            },
            error: function(){
                console.log("Error");
            }
        });
    });
</script>