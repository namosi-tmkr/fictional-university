import $ from 'jquery';

class Search {
	// 1. Describe and create/initiate our object
	constructor() {
		this.openButton 	= $(".js-search-trigger");
		this.closeButton 	= $(".search-overlay__close");
		this.searchOverlay 	= $(".search-overlay");
		this.searchField	= $("#search-term");
		this.events();
		this.isOverlayOpen 	= false;
		this.typingTimer;
		
	}


	//2. events
	events() {
		this.openButton.on("click", this.openOverlay.bind(this));
		this.closeButton.on("click", this.closeOverlay.bind(this));
		$(document).on("keydown", this.keyPressDispatcher.bind(this));
		this.searchField.on("keydown", this.typingLogic.bind(this));
	}



	//3. methods (function/action....)
	typingLogic() {
		clearTimeout(this.typingTimer);
		this.typingTimer = setTimeout(function() {console.log("this is a timeout test");} , 2000);
	}

	//to press s and esc to open and close the search overlay
	keyPressDispatcher(e) {
		// console.log(e.keyCode);
		
		if(e.keyCode == 83 && !this.isOverlayOpen)  { //s key
			this.openOverlay();
		}
		if(e.keyCode == 27 && this.isOverlayOpen){ //esc key
			this.closeOverlay();
		} 
	}


	openOverlay() {
		this.searchOverlay.addClass("search-overlay--active");
		$("body").addClass("body-no-scroll");
		this.isOverlayOpen = true;
		console.log("Our open method ran");
	}


	closeOverlay() {
		this.searchOverlay.removeClass("search-overlay--active");
		$("body").removeClass("body-no-scroll");
		this.isOverlayOpen = false;
		console.log("close method ran");
	}






}

export default Search;