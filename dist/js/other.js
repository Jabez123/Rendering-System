$(document).ready(function () {
$('#dtTrainees').DataTable();
$('.dataTables_length').addClass('bs-select');
});

function myFunction() {
	var x = document.getElementById("password");
	if (x.type === "password") {
	    x.type = "text";
	} 
	else {
	    x.type = "password";
	}
}

