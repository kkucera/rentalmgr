/**
 * Created with JetBrains PhpStorm.
 * User: kevin
 * Date: 10/31/13
 * Time: 8:26 PM
 * To change this template use File | Settings | File Templates.
 */
var acl = acl||{};
acl.resource = acl.resource||{};

acl.resource.selection = {

    containerId: 'resource-selections',
    container: null,
    submit: null,

    getContainer: function(){
        if(this.container == null){
            this.container = $('#'+this.containerId);
        }
        return this.container;
    },

    buildUi: function(response){
        if(typeof response.resources != 'object'){
            this.handleError();
        }else{
            this.getContainer();
            var resources = response.resources;
            this.container.append(this.buildResources(resources));
            this.submit = new base.submitButton({
                container: 'resource-selections-submit',
                success: this.saveSuccess,
                url: basePath+'/acl/user-resource/service/save-user-resources.json'
            });
            this.container.trigger('rendered');
        }
    },

    toggleChildren: function(event){
        var checkbox = this;
        var $checkbox = $(this);
        if(checkbox.checked){
            $checkbox.parent().find('> div.resource-block').slideDown();
        }else{
            // hide the children
            $checkbox.parent().find('div.resource-block').slideUp();
            // uncheck the children
            $checkbox.parent().find('input').attr("checked", false);
        }
    },

    checkResource: function(resourceId){
        // selectedResources should be an array of resource names that is defined external to this class.
        if($.inArray(resourceId,selectedResources)>-1){
            return 'checked';
        }
        return '';
    },

    buildResources: function(resourceArray, hide){
        var display = hide ? 'style="display: none;"' : '';
        var $blockDiv = $('<div class="resource-block" '+display+'></div>');
        for(var i=0; i<resourceArray.length; i++){
            var resource = resourceArray[i];
            var $optionDiv = $('<div class="resource-option"></div>');
            var checked = this.checkResource(resource.resourceId);
            var $checkbox = $('<input type="checkbox" name="resource[]" value="'+resource.resourceId+'" '+checked+'>');
            $checkbox.click(this.toggleChildren);
            $optionDiv.append($checkbox);
            $optionDiv.append('<span class="resource-name">'+resource.name+'</span>');
            $optionDiv.append('<span class="resource-description"> - '+resource.description+'</span>');
            if(resource.children.length>0){
                $optionDiv.append(this.buildResources(resource.children, checked==''));
            }
            $blockDiv.append($optionDiv);
        }
        return $blockDiv;
    },

    requestResources: function(){
        $.ajax({
            url: basePath+'/acl/resource/service/get-list.json',
            type: 'GET',
            success: this.buildUi,
            dataType: 'json',
            error: this.handleError,
            context: this
        });
    },

    saveSuccess: function(response){
        base.inlineMessage('User permissions have been updated.');
    },

    handleError: function(request, status, errorThrown){
        base.displayErrorResponse(request, 'Error requesting resources.');
    },

    onSelectionsRendered: function(newCallback){
        var $resultsContainer = this.getContainer();
        $resultsContainer.bind('rendered', function(){
            newCallback.call(null,$resultsContainer);
        });
    }

};
$( function(){
    acl.resource.selection.requestResources();
});