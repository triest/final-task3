function showAuthor(id) {
    //console.log(id);
    getAuthorData(id);
    //  $(".modal-content #fio").text(id.toString());
    modal.style.display = "block";
}
function getAuthorData(id) {
    var id2 = id;
    $.get("/web/review/authordata",
        {id: id},
        function (data, status) {
            console.log(data)
            $(".modal-content #fio").text(data.fio);
            $(".modal-content #email").text("Email: " + data.email);
            $(".modal-content #phone").text("Телефон:" + data.phone);
            var id2 = data.id;
            $(".modal-content #link").text("Телефон:" + data.phone);
        });
}
// Get the modal
var modal = document.getElementById('myModal');
// Get the button that opens the modal
// Get the <span> element that closes the modal
// var span = document.getElementsByClassName("close")[0];
var span = document.getElementById("close1");
// When the user clicks the button, open the modal
// When the user clicks on <span> (x), close the modal
span.onclick = function () {
    console.log("clouse");
    modal.style.display = "none";
}
// When the user clicks anywhere outside of the modal, close it
window.onclick = function (event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}