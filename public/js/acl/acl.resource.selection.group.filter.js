/**
 * Created with JetBrains PhpStorm.
 * User: kevin
 * Date: 11/9/13
 * Time: 5:55 PM
 * To change this template use File | Settings | File Templates.
 */
var acl = acl||{};
acl.resource = acl.resource||{};
acl.resource.selection = acl.resource.selection||{};
acl.resource.selection.group = {};

acl.resource.selection.group.filter = {

    init: function(){
        acl.resource.selection.onSelectionsRendered(this.filterSelectionOptions);
    },

    filterSelectionOptions: function(resourceContainer){
        if(typeof(groups) == 'object'){
            $(groups).each(function(){
                var groupName = this.name;
                $(this.resources).each(function(){
                    var input = resourceContainer.find('input[value="'+this+'"]').attr('disabled','disabled');
                    var groupsList = input.siblings('.resource-user-group-list');
                    if(groupsList.length == 0){
                        input.siblings('.resource-description').after('<span class="resource-user-group-list"> - Provided by Group: '+groupName+'</span>');
                    }else{
                        groupsList.append(', '+groupName);
                    }
                });
            });
        }
    }
};
$(function() {
    acl.resource.selection.group.filter.init();
});
