<?php

return [
    /*
     * DataTables JavaScript global namespace.
     */

    'namespace' => 'LaravelDataTables',

    /*
     * Default table attributes when generating the table.
     */
    'table' => [
        'class' => 'table table-hover dataTable table-striped w-full',
        'id' => 'dataTableBuilder',
        'style'    => 'width: 100%;',
        'data-length-menu' => '[[ 75, 100, 150,-1 ], [ 75, 100, 150, "All" ]]',
        'data-buttons' => '[{"text": "EXPORT CSV", "extend": "csvHtml5", "className": "btn btn-sm btn-default"}, {"text": "EXPORT PDF", "extend": "pdfHtml5", "className": "btn btn-sm btn-default mr-4"}]',
        'data-dom' => 't<"row"<"col-sm-12 col-md-5"<"d-flex flex-row align-items-center"<"pt-15 pr-15"l>i>><"col-sm-12 col-md-7"p>>'
    ],

    /*
     * Default condition to determine if a parameter is a callback or not.
     * Callbacks needs to start by those terms or they will be casted to string.
     */
    'callback' => ['$', '$.', 'function'],

    'order' => [0] ,

    /*
     * Html builder script template.
     */
    'script' => 'datatables::script',

    /*
     * Html builder script template for DataTables Editor integration.
     */
    'editor' => 'datatables::editor',
];
