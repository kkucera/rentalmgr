/**
 * Created with JetBrains PhpStorm.
 * User: kevin
 * Date: 10/6/13
 * Time: 5:40 PM
 * To change this template use File | Settings | File Templates.
 */

var cfm = cfm || {};
cfm.menu = function()
{
    /**
     * Initialize the menu
     */
    this.init = function(){
        $('.cfm-menu').menu({position: {at: "left bottom"}});
    }
};

$(
    function(){
        var menu = new cfm.menu();
        menu.init();
    }
);