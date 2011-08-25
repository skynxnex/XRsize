// force certain pages to be refreshed every time. mark such pages with
// 'data-cache="never"'
//
    jQuery('div').live('pagehide', function(event, ui){
      var page = jQuery(event.target);

      if(page.attr('data-cache') == 'never'){
        page.remove();
      };
    });

// for pages marked with 'data-cache="never"' manually add a back button since
// JQM doesn't. this is *okay* because we know the browswer history stack is
// intact and goes to the correct 'back' location.
// specified back button - however!
//
    jQuery('div').live('pagebeforecreate', function(event, ui){
      var page = jQuery(event.target);

      if(page.attr('data-cache') == 'never'){
        var header = page.find('[data-role="header"]');

        if(header.find('[data-rel="back"]').size() == 0){
          var back = jQuery('<a href="#" data-icon="back" data-rel="back">Back</a>');
          header.prepend(back);
        };
      };
    });

