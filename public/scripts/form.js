$(".rowid").click(function(event) {
    // alert("You clicked" + event.target.innerText);
    console.log("You clicked" + event.target.innerText);
    $.post('./delete.php', {
        delbut: event.target.innerText
    }, function(data) {
        console.log("This is what we got back"+ data);
    })


});