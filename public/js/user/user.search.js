/**
 * Created with JetBrains PhpStorm.
 * User: kevin
 * Date: 11/3/13
 * Time: 4:39 PM
 * To change this template use File | Settings | File Templates.
 */
var user = user||{};

user.search = {

    containerId: 'user-search',
    resultsContainerId: 'user-search-results',
    $container: null,
    searchTypeInput: null,
    searchValueInput: null,
    $resultsContainer: null,

    getResultsContainer: function(){
        if(this.$resultsContainer == null){
            this.$resultsContainer = $('#'+this.resultsContainerId);
        }
        return this.$resultsContainer;
    },

    getContainer: function(){
        if(this.$container == null){
            this.$container = $('#'+this.containerId);
        }
        return this.$container;
    },

    initialize: function(){
        this.buildSearchOptions();
    },

    buildSearchOptions: function(){
        var container = this.getContainer();
        var searchTypeInput = $('<select id="user-search-select" name="type"><option value="name">Name</option><option value="email">Email</option></select>');
        var searchValueInput = $('<input id="user-search-box" name="value" type="text" />');
        var self = this;
        searchValueInput.keydown(function(event){
            if(event.keyCode == 13){
                self.search(searchTypeInput.val(), searchValueInput.val());
                self.disableSearch();
            }
        });
        this.searchTypeInput = searchTypeInput;
        this.searchValueInput = searchValueInput;
        container.append(searchTypeInput);
        container.append(searchValueInput);
    },

    disableSearch: function()
    {
        this.searchTypeInput.attr('disabled','disabled');
        this.searchValueInput.attr('disabled','disabled');
    },

    enableSearch: function()
    {
        this.searchTypeInput.removeAttr('disabled');
        this.searchValueInput.removeAttr('disabled');
    },

    buildSearchResults: function(response){
        var $resultsContainer = this.getResultsContainer();
        $resultsContainer.empty();

        if(typeof response.users != 'object'){
            base.errorMessage('Unexpected response from server');
        }

        var total = response.users.length;
        var resultsTable = $('<table id="user-search-result-table" class="result-table"></table>');
        resultsTable.append('<tr><th style="display:none">ID</th><th>Name</th><th>Email</th><th>Created</th><th>Modified</th></tr>');
        for(var i=0; i<total; i++){
            var user = response.users[i];
            resultsTable.append('<tr><td style="display:none" class="user-id">'+user.id+'</td><td class="user-name">'+user.name+'</td><td class="user-email">'+user.email+'</td><td>'+user.created+'</td><td>'+user.modified+'</td></tr>');
        }
        $resultsContainer.append(resultsTable);
        $resultsContainer.trigger('rendered');
        this.enableSearch();
    },

    search: function(type, value){
        $.ajax({
            url: basePath+'/user/service/search.json',
            type: 'POST',
            data: {
                "type": type,
                "value": value
            },
            success: this.buildSearchResults,
            dataType: 'json',
            error: this.handleError,
            context: this
        });
    },

    handleError: function(request, status, errorThrown){
        base.displayErrorResponse(request, 'Error searching users.');
    },

    onResultsRendered: function(newCallback){
        var $resultsContainer = this.getResultsContainer();
        $resultsContainer.bind('rendered', function(){
            newCallback.call(null,$resultsContainer);
        });
    }
};

$(function(){
    user.search.initialize();
});