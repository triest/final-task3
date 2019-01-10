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
            $(".modal-content #fio").text(data.fio);
            $(".modal-content #phone").text("Телефон:" + data.phone);
            $(".modal-content #link").text("Телефон:" + data.phone);
            $(".modal-content #link").text("href",
                "<?= Url::toRoute(['/review/getreviewsbyautor']);?>" +  id2);
         //   $(".modal-content #link").attr("href", );
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

    modal.style.display = "none";
}
// When the user clicks anywhere outside of the modal, close it
window.onclick = function (event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}