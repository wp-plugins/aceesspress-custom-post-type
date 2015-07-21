(function ($) {
    $(function () {
         var pCount = $('#post_features_count').val();
         $('.docopy-product-feature').click(function(){
            pCount++;
            $('.product-features-wrapper').append('<div class="single-feature"><div class="single-section-wrap clearfix"><h3 class="wrapper-title">Product Feature '+pCount+'</h3>'+
                                                  '<span class="delete-select-feature"><a href="javascript:void(0)" class="delete-single-feature button">Delete Feature</a></span></div>'+
                                                  '<div class="features-single-field"><h4><span class="section-title">Feature Name</span></h4>'+
                                                  '<span class="section-inputfield"><input type="text" name="product_features['+pCount+'][feature_name]" value="" />'+
                                                  '<h4><span class="section-title">Feature Description</span></h4>'+
                                                  '<span class="section-textarea"><textarea name="product_features['+pCount+'][feature_description]" rows="7" cols="60"></textarea></span>'+
                                                  '<h4><span class="section-title">Feature Icon</span></h4>'+
                                                  '<span class="section-desc"><em>Add your fontawesome icon. Example: <strong>fa-shield</strong>. Full list of icons is <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">here</a></em></span>'+
                                                  '<span class="section-inputfield"><input type="text" name="product_features['+pCount+'][feature_icon]" value="" /></span>'+
                                                  '</div></div>'
                                                );
            
         });
         $(document).on('click', '.delete-single-feature', function(){
          // alert('test');
           $(this).parents('.single-feature').remove();
        });
    });
}(jQuery));