import $ from 'jquery';

class MyNotes {

	constructor() {
		this.events();
	}


	events() {
		$(".delete-note").on("click", this.deleteNote);
		$(".edit-note").on("click", this.editNote.bind(this));
		$(".update-note").on("click", this.updateNote.bind(this));
		$(".submit-note").on("click", this.createNote.bind(this));

	}

	//methods will go here

	//makes note editable
	editNote(e) {
		var thisNote = $(e.target).parents("li");
		if(thisNote.data("state") == "editable") {
			this.makeNoteReadOnly(thisNote);
		} else {
			this.makeNoteEditable(thisNote);
		}
		console.log('here');	
	}

	makeNoteEditable(thisNote) {
		thisNote.find(".edit-note").html('<i class="fa fa-times" aria-hidden="true"></i>Cancel');
		thisNote.find(".note-title-field, .note-body-field").removeAttr("readonly").addClass("note-active-field");
		thisNote.find(".update-note").addClass("update-note--visible");
		thisNote.data("state", "editable");
	}

	makeNoteReadOnly(thisNote) {
		thisNote.find(".edit-note").html('<i class="fa fa-pencil" aria-hidden="true"></i>Edit');
		thisNote.find(".note-title-field, .note-body-field").attr("readonly", "readonly").removeClass("note-active-field");
		thisNote.find(".update-note").removeClass("update-note--visible");
		thisNote.data("state", "cancel");
	}	

	//deletes a note
	deleteNote(e) {
		var thisNote = $(e.target).parents("li");

		$.ajax({
			//Nonce required for authorization
			beforeSend: (xhr) => {
				xhr.setRequestHeader('X-WP-Nonce', universityData.nonce);
			},
			url: universityData.root_url + '/wp-json/wp/v2/note/' + thisNote.data('id'),
			type: 'DELETE',
			
			success: (response) => {
				thisNote.slideUp(); //deletes from page and database
				console.log("congrats");
				console.log(response);
			},
			error: (response) => {
				console.log("Sorry");
				console.log(response);
			}
		});
	}

	//updates the existing note
	updateNote(e) {
		var thisNote = $(e.target).parents("li");

		var ourUpdatedPost = {
			'title': thisNote.find(".note-title-field").val(),
			'content': thisNote.find(".note-body-field").val()
		};

		$.ajax({
			//Nonce required for authorization
			beforeSend: (xhr) => {
				xhr.setRequestHeader('X-WP-Nonce', universityData.nonce);
			},
			url: universityData.root_url + '/wp-json/wp/v2/note/' + thisNote.data('id'),
			type: 'POST',
			data: ourUpdatedPost,
			
			success: (response) => {
				this.makeNoteReadOnly(thisNote);
				console.log("congrats");
				console.log(response);
			},
			error: (response) => {
				console.log("Sorry");
				console.log(response);
			}
		});
	}

	//creates a new note
	createNote(e) {
		var ourNewPost = {
			'title': $(".new-note-title").val(),
			'content': $(".new-note-body").val(),
			'status': 'publish' //by default draft
		};

		$.ajax({
			//Nonce required for authorization
			beforeSend: (xhr) => {
				xhr.setRequestHeader('X-WP-Nonce', universityData.nonce);
			},
			url: universityData.root_url + '/wp-json/wp/v2/note/',
			type: 'POST',
			data: ourNewPost,
			
			success: (response) => {
				$(".new-note-title, .new-note-body").val('');
				$('<li>Imagine real data here</li>').prependTo("#my-notes").hide().slideDown();
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