function cloudCarouselInit($, el, width, options, openOnlyActive) {
	if (width.indexOf("%") != -1) {
		width = $(el).outerWidth();

		$(el).width(width);
		$(el + "_wrapper").width(width);

		if (!options["xPos"])
			options["xPos"] = Math.round(width / 2);
		
		if (!options["xRadius"])
			options["xRadius"] = Math.round(width / 2.3);
	}

	var carousel = $(el).CloudCarousel(options);
	
	openOnlyActive = openOnlyActive || false;
	
	if (openOnlyActive) {
		$(el + " a").click(function(event) {
			if ($(this).hasClass("active"))
				return ;
			
			var data = carousel.data("cloudcarousel"),
				idx = $(this).find('img').data('itemIndex'),
				frontIndex = data.frontIndex,
				diff = idx - frontIndex,
				diff2 = idx - data.itemsCount - frontIndex;
			
			if (Math.abs(diff2) < diff)
				diff = diff2;
	
			data.rotate(-diff);
	
			event.stopImmediatePropagation();
			
			return false;
		});
	}
}