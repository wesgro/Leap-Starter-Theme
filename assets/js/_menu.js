$(function(){
  function collapseMenu(){
    $('#mobile-navigation .search-field').autocomplete().hide();
    $nav.multilevelpushmenu( 'collapse' );
    return false;
  }
  function expandMenu(){
     $nav.multilevelpushmenu( 'expand' );
    return false;
  }
  function redrawMenu(){
    if($('html').hasClass(menuExpanded)){
      $('.l-page').velocity({
        translateX: (getMenuWidth() * -1).toString()+'%',
      });
    }
    $nav.multilevelpushmenu( 'option', 'menuWidth', getMenuWidth().toString()+'%');
    $nav.multilevelpushmenu( 'redraw' );
    return false;
  }
  function getMenuWidth(){
    if($(window).width() <= 768){
      menuWidth = menuWidthBig;
    }else{
      menuWidth = menuWidthSmall;
    }
    return menuWidth;
  }
  function doAutoComplete(){
    var menuLinks = [];
    $('#mobile-navigation li a').each(function(i, e){
      menuLinks.push({value: $(this).text(), data: $(this).attr('href') });
    });
    $('#mobile-navigation .search-field').autocomplete({
      lookup: menuLinks,
      appendTo: $('#mobile-navigation .search-form'),
      onSelect: function (suggestion) {
        window.location.href = suggestion.data;
      }
  });
  }
  var $nav = $( '#mobile-navigation' );
  var menuExpanding  = 'menu-expanding';
  var menuExpanded  = 'menu-expanded';
  var menuCollapsing = 'menu-collpasing';
  var menuCollapsed = 'menu-collapsed';
  var menuWidthBig = 90;
  var menuWidthSmall = 50;
  var menuWidth = getMenuWidth().toString()+'%';
  
  
  $nav.multilevelpushmenu({
    direction: 'rtl',
    fullCollapse: true,
    collapsed:true,
    menuWidth: menuWidth,
    menuHeight: '100%',
    swipe: 'touchscreen',
    onMenuReady: function(){
      $('html').addClass(menuCollapsed);
      $nav.find('.search-form').insertAfter(".levelHolderClass>h2");
      doAutoComplete();
      $("#menu-main-menu").height($(window).height() - 100);
      
    },
    onExpandMenuStart: function() {
      console.log('Menu expanding...');
      $('html').removeClass(menuCollapsed);
      $('html').addClass(menuExpanding);
      $nav.multilevelpushmenu( 'redraw' );
      $('.l-page').velocity({
        translateX: [ (getMenuWidth() * -1).toString()+'%', 0 ],
      });
    },
    onExpandMenuEnd: function() {
      console.log('Menu expanded!');
      $('html').removeClass(menuExpanding);
      $('html').addClass(menuExpanded);
      $("#menu-main-menu").height($(window).height() - 100);
    },
    onCollapseMenuStart: function() {
      console.log('Menu collapsing...');
      $('#mobile-navigation .search-field').autocomplete().hide();
      $('html').removeClass(menuExpanded);
      $('html').addClass(menuCollapsing);
      $('.l-page').velocity({
        translateX: [0, (getMenuWidth() * -1).toString()+'%' ],
      });
    },
    onCollapseMenuEnd: function() {
      console.log('Menu collapsed!');
      $('html').removeClass(menuCollapsing);
      $('html').addClass(menuCollapsed);
      
    },
    // Just for fun also changing the look of the menu
    wrapperClass: 'mlpm_w',
    menuInactiveClass: 'mlpm_inactive'
  });
  
  /**
  * Handle toggle button
  */
  $('.menu-toggle').click(function(e){
    e.preventDefault();
    if($('html').hasClass(menuCollapsed)){
      expandMenu();
    }
    if($('html').hasClass(menuExpanded)){
      collapseMenu();
    }
  });
  $('.icon-close').click(function(){
    console.log('close the menu');
    //collapseMenu();
  });
  /**
  * Hide the menu when a click is detected off the menu
  */
  /*
$('.csstransforms .l-page').click(function(e){
    if($('html').hasClass(menuExpanded)){
      e.preventDefault();
      e.stopPropagation();
      //collapseMenu();
      return false;
    }
  });
*/
  
  
  
  
  /**
  * Needs the debounce/throttle jquery plugin 
  * http://benalman.com/projects/jquery-throttle-debounce-plugin/
  */
  $(window).resize($.throttle( 250, redrawMenu));
});





