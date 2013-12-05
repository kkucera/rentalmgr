/**
 * Created with JetBrains PhpStorm.
 * User: kevin
 * Date: 11/15/13
 * Time: 5:49 PM
 * To change this template use File | Settings | File Templates.
 */

var user = user||{};
user.dataTable = function(config){

    var tableId = config.tableId||'#user-data-table';
    var serverUrl = config.serverUrl||basePath+"/user/service/data-table.json";
    var link = config.userNameLink||null;

    var initialize = function(){
        $(tableId).dataTable( {
            "bProcessing": true,
            //"bServerSide": true, if data set gets to large and need to do server side processing just uncomment this
            "sServerMethod": 'POST',
            "bJQueryUI": true,
            "sAjaxSource": serverUrl,
            "aoColumns":[
                { "bSearchable": false, "bVisible": false },
                { "fnRender": function (oObj) {
                    if(link){
                        return '<a href="'+link+oObj.aData[0]+'">'+oObj.aData[1]+'</a>';
                    }else{
                        return oObj.aData[1];
                    }
                }
                },
                null,null,null
            ]
        } );
    };

    initialize();
};