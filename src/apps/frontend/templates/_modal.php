if (jq('a.modal').length != 0) {
  jq('a.modal').fancybox({
                         'speedIn'	: 100, 
                         'speedOut'	: 100, 
                         'overlayShow'	: true,
                         'overlayOpacity' : 0.8,
                         'scrolling'     : 'no', 
                         'titleShow'     : false,
                         'transitionIn'  : 'fade',
                          'onComplete'    : function () {
                                            resize_blocks();
                                            jq("#name").focus();
                                           },
                         'onClosed'      : function () {
                                            resize_blocks();
                                           }
                         });
}
