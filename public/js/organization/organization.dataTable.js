/**
 * Created with JetBrains PhpStorm.
 * User: kevin
 * Date: 11/15/13
 * Time: 5:49 PM
 */

var organization = organization||{};
organization.dataTable = function(config){

    var tableId = config.tableId||'#organization-data-table';
    var serverUrl = config.serverUrl||basePath+"/organization/service/data-table.json";
    var link = config.organizationNameLink||null;
    var deleteLink = config.organizationDeleteLink||null;
    var table = null;

    var initialize = function(){

        $(tableId).on('click', 'div.delete-icon', function (e) {
            e.preventDefault();
            var id = $(this).attr('orgId');
            var row = $(this).parents('tr')[0];
            var organizationName = $(row).find('.organization-name').html();
            if(!base.confirm('Are you sure you wish to delete organization '+id+' - '+organizationName)){
                return;
            }

            $.ajax({
                url:deleteLink+id,
                type: 'GET',
                success: function(response){
                    table.fnDeleteRow(row);
                },
                dataType: 'json',
                error: function(request){
                    base.displayErrorResponse(request, 'Error deleting organization.');
                },
                context: this
            });
        } );

        $(tableId).on('click', 'div.edit-icon', function (e) {
            e.preventDefault();
            var id = $(this).attr('orgId');
            window.location = link+id;
        } );

        table = $(tableId).dataTable( {
            "bProcessing": true,
            //"bServerSide": true, if data set gets to large and need to do server side processing just uncomment this
            "sServerMethod": 'POST',
            "bJQueryUI": true,
            "sAjaxSource": serverUrl,
            "aoColumns":[
                { "bSearchable": false, "bVisible": false },
                { "fnRender": function (oObj) {
                    if(link){
                        return '<a href="'+link+oObj.aData[0]+'"><span class="organization-name">'+oObj.aData[1]+'</span></a>';
                    }else{
                        return oObj.aData[1];
                    }
                }},
                null,null,
                {
                    "bSearchable": false,
                    "bSortable":false,
                    "mData": null,
                    "fnRender": function (oObj) {
                        return '<div class="delete-icon" orgId="'+oObj.aData[0]+'"></div><div class="edit-icon" orgId="'+oObj.aData[0]+'"></div>';
                    }
                }
            ]
        } );
    };

    initialize();
};

$(
    function(){
        organization.dataTable({
            'organizationNameLink': basePath+'/organization/edit/',
            'organizationDeleteLink': basePath+'/organization/service/delete/'
        });
    }
);