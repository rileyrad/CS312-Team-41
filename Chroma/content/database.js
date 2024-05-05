$(document).ready(function() {

    $("#addColor").submit(function(event) {
        event.preventDefault();

        var formData = $(this).serialize();

        $.ajax({
            type: "POST",
            url: "add_color.php",
            data: formData,
            success: function(response) {

                $("#addError").text(response);
            }
        });
    });
});