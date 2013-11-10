/**
 * Created with JetBrains PhpStorm.
 * User: kevin
 * Date: 11/3/13
 * Time: 7:13 PM
 * To change this template use File | Settings | File Templates.
 */
var acl = acl||{};
acl.user = acl.user||{};
acl.user.resource = acl.user.resource||{};

acl.user.resource.search = {

    init: function(){
        user.search.onResultsRendered(this.decorateUserSearchResult);
    },

    decorateUserSearchResult: function(resultTable){
        resultTable.find('tr').each(function(){
            var id = $(this).find('.user-id').text();
            var name = $(this).find('.user-name').text();
            var link = '<a href="'+basePath+'/acl/user-resource/edit/'+id+'">'+name+'</a>';
            $(this).find('.user-name').html(link);
        });
    }
};
$(function() {
    acl.user.resource.search.init();
});
