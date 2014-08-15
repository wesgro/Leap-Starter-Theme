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
    collapseMenu();
    $nav.multilevelpushmenu( 'option', 'menuWidth', getMenuWidth().toString()+'%');
    $nav.multilevelpushmenu( 'option', 'menuHeight', getMenuHeight().toString()+'px');
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
  function getMenuHeight(){
    var documentHeight = $(document).height();
    var pageHeight = $('.l-page').height();
    console.log( Math.max(documentHeight, pageHeight));
    return Math.max(documentHeight, pageHeight);
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
    containersToPush: $('.l-page'),
    direction: 'rtl',
    fullCollapse: true,
    collapsed:true,
    menuWidth: menuWidth,
    menuHeight: '100%',
    swipe: 'touchscreen',
    backItemIcon: 'icon-fontawesome-webfont',
		groupIcon: 'icon-fontawesome-webfont-1',
    onMenuReady: function(){
      $('html').addClass(menuCollapsed);
      $nav.find('.search-form').insertAfter(".mlpm_w > .levelHolderClass>h2");
      doAutoComplete();
      redrawMenu();
    },
    onExpandMenuStart: function(e) {
      console.log('Menu expanding...');
      $('html').removeClass(menuCollapsed);
      $('html').addClass(menuExpanding);
      $nav.multilevelpushmenu( 'option', 'menuHeight', getMenuHeight().toString()+'px');
      $nav.multilevelpushmenu( 'redraw' );
    },
    onExpandMenuEnd: function(e) {
      console.log('Menu expanded!');
      $('html').removeClass(menuExpanding);
      $('html').addClass(menuExpanded);
      $(".mlpm_w").height($(window).height() - 100);
    },
    onCollapseMenuStart: function(e) {
      /* console.log('Menu collapsing...'); */
      $('#mobile-navigation .search-field').autocomplete().hide();
      $('html').removeClass(menuExpanded);
      $('html').addClass(menuCollapsing);
    },
    onCollapseMenuEnd: function(e) {
      /* console.log('Menu collapsed!'); */
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

    //collapseMenu();
  });
  
  
  
  
  /**
  * Needs the debounce/throttle jquery plugin 
  * http://benalman.com/projects/jquery-throttle-debounce-plugin/
  */
  $(window).resize($.throttle( 250, redrawMenu));
});