//document.addEventListener( 'DOMContentLoaded', function( event ) {
    var config = (function(){
        'use strict';

        //=================================================================================================================
        // Private variables for the Module
        //var people = ['Will', 'Steve'];
        var configVal = new Map();
        
        //=================================================================================================================
        // Variables cached from the DOM
        var $document = $(document);
        var $ajaxError = $(".ajaxError");
        var $wildcard = $('*');
        /*
        var $el = $('#peopleModule');
        var $button = $el.find('button');
        var $input = $el.find('input');
        var $ul = $el.find('ul');
        var template = $el.find('#people-template').html();
        */

        // When the javascript initializes do a one time get of the logo image data (for PDF writes)
	    $.get("getLogoImgData.php",function(logoImgDataResults){
            configVal.set('pdfLogoImgData',logoImgDataResults);
	    });

	    // When the page loads, get the Config values from the database table
	    $.getJSON("getHoaConfigList.php","",function(hoaConfigRecList){
            console.log("hoaConfigRecList.length = "+hoaConfigRecList.length);
            $.each(hoaConfigRecList, function(index, configRec) {
                configVal.set(configRec.ConfigName,configRec.ConfigValue);
            });
        });

        
        //=================================================================================================================
        // Bind events
        //$button.on('click', addPerson);
        //$ul.delegate('i.del', 'click', deletePerson);              

        //=================================================================================================================
        _render();
        function _render() {
           //$ul.html(Mustache.render(template, {people: people}));
        }
        
        //=================================================================================================================
        // Module methods
        function getVal(name) {
            console.log("name = "+name);
            console.log("configVal.get(name) = "+configVal.get(name));
            console.log("configVal.get(name) = "+configVal.get('hoaName'));
            return configVal.get(name);
        }
        
        //=================================================================================================================
        // This is what is exposed from this Module
        return {
            getVal
        };
        
    })(); // var util = (function(){
//}); // document.addEventListener( 'DOMContentLoaded', function( event ) {
// util.cleanStr("this to clean");
    
/*
    function addPerson(value) {
        var name = (typeof value === "string") ? value : $input.val();
        people.push(name);
        _render();
        $input.val('');
    }
    function deletePerson(event) {
        var i;
        if (typeof event === "number") {
            i = event;
        } else {
            var $remove = $(event.target).closest('li');
            i = $ul.find('li').index($remove);
        }
        people.splice(i, 1);
        _render();
    }
*/  
  


