'use strict';

let dtCrawlerLogs;
$(document).ready(function () {
    dtCrawlerLogs = $('#crawler-logs-table').DataTable({
        "oLanguage": {
            "sEmptyTable": _pageLang.no_data ?? '',
        },
        "aLengthMenu": [[15,25, 50, 100], [15,25, 50, 100]],
        "pageLength": 15,
        "bLengthChange": false,
        "order": [[4, "desc"]],
        "dom": 'lrtip',
        "responsive": true,
        initComplete: function () {
            this.api().columns().every( function (colIdx) {
                if( colIdx == 2 ){
                    var column = this;
                    var select = $(`<select><option value="">${_pageLang.crawler_type}</option></select>`)
                        .appendTo( $(column.header()).empty() )
                        .on( 'change', function () {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );

                            column
                                .search( val ? '^'+val+'$' : '', true, false )
                                .draw();
                        } );

                    column.data().unique().sort().each( function ( d, j ) {
                        select.append( '<option value="'+d+'">'+d+'</option>' )
                    } );
                }
            } );
        }
    });

    //// Attach DataTables search to custom input
    $('#searchInputCrawlerLogs').on('keyup', function() {
        dtCrawlerLogs.search(this.value).draw();
    });
});

