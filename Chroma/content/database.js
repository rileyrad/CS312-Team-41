$(document).ready(function() {

    $("#addColor").submit(function(event) {
        event.preventDefault();

        var formData = $(this).serialize();

        $.ajax({
            type: "POST",
            url: "content/add_color.php",
            data: formData,
            success: function(response) {

                $("#addError").text(response);
                $("#colorName").val("");
                $("#colorHex").val("");
            },
            error: function(xhr, status, error) {
                $("#addError").text("Error: " + error);
            }
        });
    });
});