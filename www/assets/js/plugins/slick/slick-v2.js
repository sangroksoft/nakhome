  $('.slick-v2').slick({
    centerMode: true,
    //centerMode: false,
    slidesToShow: 3,
    infinite: true,
    focusOnSelect: true,
	/*
    focusOnSelect: true,
    prevArrow: '<span data-role="none" class="" aria-label="Previous"></span>',
    nextArrow: '<span data-role="none" class="" aria-label="Next"></span>',
	*/
    arrows: false,

    responsive: [
      {
        breakpoint: 1600,
        settings: {
          slidesToShow: 3,
        }
      },
      {
        breakpoint: 1200,
        settings: {
          slidesToShow: 3,
        }
      },
      {
        breakpoint: 992,
        settings: {
          slidesToShow: 2,
        }
      },
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 2
        }
      },
      {
        breakpoint: 550,
        settings: {
          slidesToShow: 1
        }
      }
    ]
  });
