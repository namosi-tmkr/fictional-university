import $ from 'jquery';

class MyNotes {

	constructor() {
		this.events();
	}


	events() {
		$(".delete-note").on("click", this.deleteNote);

	}

	//methods will go here

	deleteNote() {
		$.ajax({
			//Nonce required for authorization
			beforeSend: (xhr) => {
				xhr.setRequestHeader('X-WP-Nonce', universityData.nonce);
			},
			url: universityData.root_url + '/wp-json/wp/v2/note/92',
			type: 'DELETE',
			
			success: (response) => {
				console.log("congrats");
				console.log(response);
			},
			error: (response) => {
				console.log("Sorry");
				console.log(response);
			}
		});
	}

}

export default MyNotes;