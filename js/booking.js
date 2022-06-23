if(bs == 0)
{
    var book_no = document.getElementById("booked_no");
    book_no.classList.remove("invisible");

    var book_yes = document.getElementById("booked_yes");
    book_yes.classList.add("invisible");
}
else
{
    var book_no = document.getElementById("booked_yes");
    book_no.classList.remove("invisible");

    var book_yes = document.getElementById("booked_no");
    book_yes.classList.add("invisible");
}