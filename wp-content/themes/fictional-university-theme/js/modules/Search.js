import $ from 'jquery';

class Search {
	// 1. Describe and create/initiate our object
	constructor() {
		this.addSearchHTML(); //must be at beginning
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
				this.typingTimer = setTimeout(this.getResults.bind(this), 750);
			} else {
				this.resultsDiv.html('');
				this.isSpinnerVisible = false;
			}

			
		}
		
		this.previousValue = this.searchField.val();
	}


	//to get results called by timeout method
	getResults() {
		$.getJSON(universityData.root_url + '/wp-json/university/v1/search?term=' + this.searchField.val(), (results) => {
			this.resultsDiv.html(`
				<div class="row">
					<div class="one-third">
						<h2 class="search-overlay__section-title">General Information</h2>
						${results.generalInfo.length ? '<ul class="link-list min-list">' : '<p>No general information match that search. </p>'}
							${results.generalInfo.map(item => `<li><a href="${item.permalink}">${item.title}</a> ${item.postType == 'post' ? `by ${item.author_name}` : ''}</li>`).join('')}	
						${results.generalInfo.length ? '</ul>' : ''}
					</div>

					<div class="one-third">
						<h2 class="search-overlay__section-title">Programs</h2>
						${results.programs.length ? '<ul class="link-list min-list">' : `<p>No programs match that search. <a href="${universityData.root_url}/programs">View all programs</a></p>`}
							${results.programs.map(item => `<li><a href="${item.permalink}">${item.title}</a> </li>`).join('')}	
						${results.programs.length ? '</ul>' : ''}


						<h2 class="search-overlay__section-title">Professors</h2>
					</div>

					<div class="one-third">
						<h2 class="search-overlay__section-title">Campuses</h2>
						${results.campuses.length ? '<ul class="link-list min-list">' : `<p>No campuses match that search. <a href="${universityData.root_url}/campuses">View all campuses</a> </p>`}
							${results.campuses.map(item => `<li><a href="${item.permalink}">${item.title}</a> </li>`).join('')}	
						${results.campuses.length ? '</ul>' : ''}


						<h2 class="search-overlay__section-title">Events</h2>
					</div>
				</div>
			`);
			this.isSpinnerVisible = false;
		});


		/* old code used before custom rest api was made
		//when: asynchronously run JSON requests
		//1st parameter of when is gonna map to 1st parameter of then and so on
		$.when(
			$.getJSON(universityData.root_url + '/wp-json/wp/v2/posts?search=' + this.searchField.val()),
			$.getJSON(universityData.root_url + '/wp-json/wp/v2/pages?search=' + this.searchField.val())
			).then((posts, pages) => {
			var combinedResults = posts[0].concat(pages[0]); //combine multiple arrays
				this.resultsDiv.html(`
				<h2 class="search-overlay__section-title">General Information</h2>
				${combinedResults.length ? '<ul class="link-list min-list">' : '<p>No general information present..</p>'}
					${combinedResults.map(item => `<li><a href="${item.link}">${item.title.rendered}</a> ${item.type == 'post' ? `by ${item.author_name}` : ''}</li>`).join('')}	
				${combinedResults.length ? '</ul>' : ''}
				
				`);
			this.isSpinnerVisible = false;
		}, () => {
			this.resultsDiv.html('<p>Unexpected error please try again</p>'); //to view if error arises while running script
		}); 
		*/

		/* oldest code before when().then()  i.e synchronous method
		$.getJSON(universityData.root_url + '/wp-json/wp/v2/posts?search=' + this.searchField.val(), posts => { //function(posts) is replaced by posts=>(ES6 arrow function) in order to bind(this)			
			//template literal use here
			$.getJSON(universityData.root_url + '/wp-json/wp/v2/pages?search=' + this.searchField.val(), pages => {
				var combinedResults = posts.concat(pages); //combine multiple arrays
				//content cutted above
			});
		}); */
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
		this.searchField.val('');
		setTimeout(() => this.searchField.focus() , 301); //to put cursor in textfield automatically
		this.isOverlayOpen = true;
		console.log("Our open method ran");
	}


	closeOverlay() {
		this.searchOverlay.removeClass("search-overlay--active");
		$("body").removeClass("body-no-scroll");
		this.isOverlayOpen = false;
		console.log("close method ran");
	}


	//search overlay 
	addSearchHTML() {
		$("body").append(`

			<div class="search-overlay">
				<div class="search-overlay__top">
					<div class="container">
						<i class="fa fa-search search-overlay__icon" aria-hidden="true"></i>
						<input type="text" class="search-term" placeholder="What are you looking for?" id="search-term">
						<i class="fa fa-window-close search-overlay__close" aria-hidden="true"></i>

					</div>
				</div>

				<div class="container">
					<div id="search-overlay__results">

					</div>
				</div>
			</div>

			`);
	}






}

export default Search;