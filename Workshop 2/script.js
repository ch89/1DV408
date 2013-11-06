var deleteButtons = document.querySelectorAll(".delete");

for(var i = 0; i < deleteButtons.length; i++) {
	deleteButtons[i].addEventListener("click", confirmDelete);
}

function confirmDelete(e) {
	if(!confirm("Are you sure you want to delete?")) {
		e.preventDefault();
	}
}