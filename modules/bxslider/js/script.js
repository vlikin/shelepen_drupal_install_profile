(function ($, drupalSettings) {
  $(document).ready(function() {
    $('.bxslider:not(.bxslider-processed)')
      .addClass('bxslider-processed')
      .each(function() {
        var dom = $(this);
        var ukey = dom.attr('data-ukey');
        var settings = drupalSettings.bxslider.formatter[ukey];
        dom.bxSlider(settings);
    });
  });
})(jQuery, drupalSettings);