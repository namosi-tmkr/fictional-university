import $ from 'jquery';

class Search {
	// 1. Describe and create/initiate our object
	constructor() {
		this.openButton 	  = $(".js-search-trigger"); //search button
		this.closeButton 	  = $(".search-overlay__close"); //cross button
		this.searchOverlay 	  = $(".search-overlay"); //transparent overlay
		this.searchField	  = $("#search-term"); //text field
		this.events();
		this.isOverlayOpen 	  = false; //check if the overlay is open or not
		this.typingTimer; //to set timer when a button is pressed in search field
		this.resultsDiv		  = $("#search-overlay__results"); //the results container div
		this.isSpinnerVisible = false; //check the spinner visibility
		this.previousValue; //to check previous search string
		
	}


	//2. events
	events() {
		this.openButton.on("click", this.openOverlay.bind(this));
		this.closeButton.on("click", this.closeOverlay.bind(this));
		$(document).on("keydown", this.keyPressDispatcher.bind(this));
		this.searchField.on("keyup", this.typingLogic.bind(this));
	}



	//3. methods (function/action....)
	typingLogic() {
		if(this.searchField.val() != this.previousValue) {
			clearTimeout(this.typingTimer);

			if(this.searchField.val()) {
				if(!this.isSpinnerVisible) {
					this.resultsDiv.html('<div class="spinner-loader"></div>');
					this.isSpinnerVisible = true;
				}
				this.typingTimer = setTimeout(this.getResults.bind(this), 2000);
			} else {
				this.resultsDiv.html('');
				this.isSpinnerVisible = false;
			}

			
		}
		
		this.previousValue = this.searchField.val();
	}


	//to get results called by timeout method
	getResults() {
		// this.resultsDiv.html("Imagine real search results here");
		// this.isSpinnerVisible = false;

		$.getJSON('http://localhost:3000/wp-json/wp/v2/posts?search=' + this.searchField.val(), posts => { //function(posts) is replaced by posts=>(ES6 arrow function) in order to bind(this)			
			//template literal use here
			this.resultsDiv.html(`
				<h2 class="search-overlay__section-title">General Information</h2>
				<ul class="link-list min-list">
					${posts.map(item => `<li><a href="">${item.title.rendered}</a></li>`).join('')}
				</ul>
				`);
		});
	}




	//to press s and esc to open and close the search overlay
	keyPressDispatcher(e) {
		// console.log(e.keyCode);
		
		if(e.keyCode == 83 && !this.isOverlayOpen && !$("input, textarea").is(':focus')) { //s key
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