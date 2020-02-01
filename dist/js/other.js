$(document).ready(function () {
$('#dtTrainees').DataTable();
$('.dataTables_length').addClass('bs-select');
});

function myFunction() {
  var x = document.getElementById("password");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }

  var y = document.getElementById("confirm_password");
  if (y.type === "password") {
  	y.type = "text";
  } else {
  	y.type = "password";
  }
} 

function copyText(e) {
  document.getElementById("class_group").value = e.target.value;
}