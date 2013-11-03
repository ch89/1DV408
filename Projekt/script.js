var deleteButtons = document.querySelectorAll(".delete");

for(var i = 0; i < deleteButtons.length; i++) {
	deleteButtons[i].addEventListener("click", confirmDelete);
}

function confirmDelete(e) {
	if(!confirm("you sure?")) {
		e.preventDefault();
	}
}