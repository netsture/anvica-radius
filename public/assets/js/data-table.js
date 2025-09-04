// npm package: datatables.net-bs5
// github link: https://github.com/DataTables/Dist-DataTables-Bootstrap5

$(function() {
    'use strict';

    var defaultLength = $('#dataTableExample').data('display-length') || 10;

    $(function() {
        var table = $('#dataTableExample').DataTable({
            "aLengthMenu": [
              [10, 30, 50, 100, -1],
              [10, 30, 50, 100, "All"]
            ],
            // "iDisplayLength": 100,
            "iDisplayLength": defaultLength,
            "language": {
              search: ""
            }
        });

        
    
        $('#dataTableExample').each(function() {
            var datatable = $(this);
            // SEARCH - Add the placeholder for Search and Turn this into in-line form control
            var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
            search_input.attr('placeholder', 'Search');
            search_input.removeClass('form-control-sm');
            // LENGTH - Inline-Form control
            var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
            length_sel.removeClass('form-control-sm');
        });

        // Search by Appt. Date
        $('#search_appt_date').on('keyup change', function () {
            table.column(5).search(this.value).draw();
        });

        // Filter by Clinic Dropdown
        $('#search_clinic').on('change', function () {
            table.column(1).search(this.value).draw();
        });

        // Option List Filter by Category
        $('#search_category').on('change', function () {
            table.column(1).search(this.value).draw();
        });
    });
    
});