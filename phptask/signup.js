$('#exampleModal').on('show.bs.modal', function (event) {
    var button = $(event.exampleModal); // Button that triggered the modal
    var id = button.data('id');
    var name = button.data('name');
    var email = button.data('email');
    var number = button.data('number');
    
    // Update the form fields
    $('#edit-id').val(id);
    $('#recipient-name').val(name);
    $('#recipient-email').val(email);
    $('#recipient-number').val(number);
});
$(document).ready(function() {
    // Attach click event to the button
    $('#edit-id').on('click', function() {
        // Get data attributes
        var id = $(this).data('id');
        
        // Send AJAX request to fetch data from the server
        $.ajax({
            url: 'edit.php', // Replace with the actual path to your PHP script
            type: 'GET',
            data: { id: id },
            dataType: 'json',
            success: function(response) {
                // Check if the request was successful
                if (response.success) {
                    // Set modal content based on the data received\
                    $('#recipient-name').val(response.data.name);
                    $('#recipient-email').val(response.data.email);
                    $('#recipient-number').val(response.data.number);

                    // Show the modal
                    $('#exampleModal1').modal('show');
                } else {
                    // Handle errors if needed
                    alert('Error fetching data from the server');
                }
            },
            error: function(xhr, status, error) {
                // Handle AJAX errors if needed
                console.error(xhr.responseText);
            }
        });
    });
});
