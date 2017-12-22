<?php  ?>

<script type="text/javascript">
  $(".full_height_banner .owl-carousel, .landing_page_banner .owl-carousel").owlCarousel({
   navigation : false, // Show next and prev buttons
  //  speed: 300,
   slidesToShow: 5,
   slidesToScroll: 4,
   slideSpeed : 300,
   paginationSpeed : 400,
   autoWidth: false,
   items: 1,
   singleItem:true,
   animateOut: 'fadeOut',
   dots: true,
   loop: true,
   responsive: {
     0:{
       autoplay: false,
       touchDrag: false,
       mouseDrag: false
     },
     669:{
       autoplay: true,
     }
   }
  });
</script>
