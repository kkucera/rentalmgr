/**
 * Created with JetBrains PhpStorm.
 * User: kevin
 * Date: 9/14/13
 * Time: 12:15 PM
 * To change this template use File | Settings | File Templates.
 */

var timeOutSeconds = 300;
var warningSeconds = 10;
var logoutUrl = '/logout';

// setup the namespace
var auth = {};
auth.auto = {};


auth.auto.logout = function() {

    var timeOutMilli = timeOutSeconds * 1000;
    var warningMilli = warningSeconds * 1000;
    var $warnDialog = null;
    var countDownTimer = null;
    var $countDownSpan = null;

    var warn = function(){
        $countDownSpan.text(warningSeconds + 1);
        $warnDialog.dialog('open');
        countDown();
    };

    var logout = function(){
        $logoutForm = $('<form method="POST" action="'+logoutUrl+'"><input type="hidden" name="message" value="You have been logged out due to inactivity."></form>');
        $('body').append($logoutForm);
        $logoutForm.submit();
    };

    var countDown = function(){
        var seconds = parseInt($countDownSpan.text());
        if(seconds > 0){
            $countDownSpan.text(seconds - 1);
            countDownTimer = setTimeout(countDown,1000);
            return;
        }
        logout();
    };

    this.start = function(){
        setTimeout(warn, timeOutMilli-warningMilli);
    };

    this.init = function(){
        var self = this;
        $warnDialog = $('<div>You will be logged out in: <span id="auto-logout-countDown"></span> seconds</div>');
        $('body').append($warnDialog);
        $countDownSpan = $warnDialog.find('#auto-logout-countDown');
        $warnDialog.dialog({
            resizable: false,
            height:140,
            modal: true,
            autoOpen: false,
            title: 'Inactive Session',
            buttons: {
                "Continue Working": function() {
                    clearTimeout(countDownTimer);
                    self.start();
                    $( this ).dialog( "close" );
                }
            }
        });

        this.start();
    }

};

$(
    function(){
        var autoLogout = new auth.auto.logout();
        autoLogout.init();
    }
);

