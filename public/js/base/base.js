/**
 * Created with JetBrains PhpStorm.
 * User: kevin
 * Date: 10/31/13
 * Time: 9:25 PM
 * To change this template use File | Settings | File Templates.
 */
var base = base||{};

base.containerNotFound = function(container){
    var containerId = container;
    this.toString = function(){
        return 'Container with id ['+containerId+'] was not found';
    }
};

base.errorMessage = function(message)
{
    alert(message);
};

base.displayErrorResponse = function(response, message)
{
    if(response.responseJSON){
        var error = response.responseJSON.error;
        message += "\n"+error.status;
        message += "\n"+error.message;
        message += "\n"+error.uri;
    }
    base.errorMessage(message);
};

base.confirm  = function(message){
  return confirm(message);
};

base.submitButton = function(config){
    var button = null;
    var url = null;
    var form = null;
    var success = null;
    var busyIcon = null;

    var getContainer = function(containerId){
        var $container = null;
        if(containerId){
            $container = $('#'+containerId);
        }
        if($container == null || $container.length == 0){
            throw new base.containerNotFound(containerId);
        }
        return $container;
    };

    var init = function(config){
        var container = getContainer(config.container);
        success = config.success;
        url = config.url;
        form = container.closest("form");
        var buttonLabel = container.text();
        container.empty().addClass('base-submit-button-container');
        button = $('<div>'+buttonLabel+'</div>').button();
        button.click(submit);
        busyIcon = $('<div class="base-submit-busy-icon" style="display:none"></div>');
        container.append(button).append(busyIcon);
    };

    var submit = function(){
        if(!url){
            base.errorMessage('submit action not specified');
            return;
        }
        button.attr('disabled','disabled');
        busyIcon.fadeIn();
        $.ajax({
            url: url,
            type: 'POST',
            success: function(response){
                button.removeAttr('disabled');
                busyIcon.fadeOut();
                success.call(null, response);
            },
            dataType: 'json',
            error: function(request){
                button.removeAttr('disabled');
                busyIcon.fadeOut();
                base.displayErrorResponse(request);
            },
            data: form.serialize()
        });
    };

    init(config);
};

/**
 * Builds an inline message div adding the message you pass in.
 * @param config
 */
base.inlineMessage = function(config){

    var buildMessageDiv = function(message, container){
        var messageContainer = $('<div class="base-inline-message" style="display:none"></div>');
        var messageExit = $('<div class="base-inline-message-exit">x</div>').click(function(){
            $(this).parent().slideUp('normal', function() { $(this).remove(); });
        });
        messageContainer.append(messageExit);
        messageContainer.append($('<div>'+message+'</div>'));
        container.append(messageContainer);
        messageContainer.slideDown();
    };

    var getContainer = function(containerId){
        var $container = null;
        if(containerId){
            $container = $('#'.containerId);
        }
        if($container == null || $container.length == 0){
            $container = $('#base-inline-message');
        }
        if($container == null || $container.length == 0){
            $container = $('body');
        }
        return $container;
    };

    var init = function(config){
        var message = null;
        var container = null;
        if(typeof(config) == 'string'){
            message = config;
            container = getContainer();
        }else if(typeof(config) == 'object'){
            message = config.message;
            container = getContainer(config.container);
        }else{
            console.error('Error: improper use of base.inlineMessage must call with string message or config object');
        }
        buildMessageDiv(message, container);
    };

    init(config);
};