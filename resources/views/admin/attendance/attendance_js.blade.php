<script>
    // Flatpickr start time
    var basicPickr = $('.flatpickr-basic');
    if (basicPickr.length) {
        basicPickr.flatpickr({
            dateFormat: 'Y-m-d',
        });
    }

    // Flatpickr end time
    var basicPickr2 = $('.flatpickr-basic2');
    if (basicPickr2.length) {
        basicPickr2.flatpickr({
            dateFormat: 'Y-m-d',
        });
    }
    

    // attendance report datatable
    $(function () {
        var table = $('.attendance-report-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            searching: false,
            "bLengthChange": false,
            "pageLength": 15,
            "order": [[1, 'asc']],
            "language": {
                processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>',
                paginate: {
                    previous: '&nbsp;',
                    next: '&nbsp;'
                }
            },

            dom: 'lBfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fas fa-file-excel"></i> Excel',
                    title : function() {
                        return "Attendance Report";
                    },
                    titleAttr: 'Excel',
                    className: 'btn-primary'
                },
                {
                    extend: 'csvHtml5',
                    text: '<i class="fas fa-file-csv"></i> CSV',
                    title : function() {
                        return "Attendance Report";
                    },
                    titleAttr: 'CSV',
                    className: 'btn-primary'
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="fas fa-file-pdf"></i> PDF',
                    title : function() {
                        return "Attendance Report";
                    },
                    customize: function(doc) {
                        doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                    },
                    orientation : 'landscape',
                    pageSize : 'LEGAL',
                    titleAttr : 'PDF',
                    className: 'btn-primary'
                },
                {
                    extend: 'print',
                    text: '<i class="fas fa-print"></i> Print',
                    title : function() {
                        return "Attendance Report";
                    },
                    titleAttr: 'Print',
                    className: 'btn-primary'
                }
    
            ],


            ajax: {
                url: "{{ route('attendance.report') }}",
                type: 'GET',
                data: function (d) {
                    d.emp_id = $('#emp_id').val();
                    d.start_time = $('#start_time').val();
                    d.end_time = $('#end_time').val();
                }
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'emp_id', name: 'emp_id'},
                {data: 'name', name: 'name'},
                {data: 'department_name', name: 'department_name'},
                {data: 'position', name: 'position'},
                {data: 'auth_date', name: 'auth_date'},
                {data: 'check_in', name: 'check_in'},
                {data: 'check_out', name: 'check_out'},
                {data: 'work', name: 'work'},
                {data: 'ot', name: 'ot'},
                {data: 'attend', name: 'attend'},
                {data: 'status', name: 'status'},
            ],
        });

        $('#attendance_report_search').on('submit', function (event) {
            event.preventDefault();
            table.draw(true);
        });
    });

    // datatable form reset
    function form_reset() {
        document.getElementById("attendance_report_search").reset();
        $('.attendance-report-table').DataTable().ajax.reload(null, false);
        window.location.reload(true);
    }
</script>