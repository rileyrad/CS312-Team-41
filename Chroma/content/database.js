$(document).ready(function() {
    function populateDropdowns() {
        $.ajax({
            type: "GET",
            url: "content/get_colors.php",
            dataType: "json",
            success: function(response) {
                var modifyDropdown = $("#modifyColorSelect");
                modifyDropdown.empty();
                $.each(response, function(index, color) {
                    modifyDropdown.append('<option value="' + color.id + '">' + color.name + '</option>');
                });

                var deleteDropdown = $("#deleteColorSelect");
                deleteDropdown.empty();
                $.each(response, function(index, color) {
                    deleteDropdown.append('<option value="' + color.id + '">' + color.name + '</option>');
                });
            },
            error: function(xhr, status, error) {
                console.error("Error fetching color names: " + error);
            }
        });
    }

    populateDropdowns();

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

    $("#modifyColor").submit(function(event) {
        event.preventDefault();

        var formData = $(this).serialize();

        $.ajax({
            type: "POST",
            url: "content/modify_color.php",
            data: formData,
            success: function(response) {
                $("#modifyError").text(response);
                $("#modifyColorName").val("");
                $("#modifyColorHex").val("");
            },
            error: function(xhr, status, error) {
                $("#modifyError").text("Error: " + error);
            }
        });
    });

    $("#deleteColor").submit(function(event) {
        event.preventDefault();

        var formData = $(this).serialize();

        $.ajax({
            type: "POST",
            url: "content/delete_color.php",
            data: formData,
            success: function(response) {
                $("#deleteError").text(response);
            },
            error: function(xhr, status, error) {
                $("#deleteError").text("Error: " + error);
            }
        });
    });

});