$(document).ready(function() {
    // Attach click event to the button
    $('.edit-id').on('click', function() {
        // Get data attributes
        var id = $(this).data('id');
        
        // Send AJAX request to fetch data from the server
        $.ajax({
            url: './edit.php', // Replace with the actual path to your PHP script
            type: 'GET',
            data: { id: id },
            dataType: 'json',
            success: function(response) {
                // Check if the request was successful
                if (response.success) {
                    console.log(response.data.id);
                    $('#update-id').val(id);
                    $('#update-name').val(response.data.name);
                    $('#update-email').val(response.data.email);
                    $('#update-number').val(response.data.number);

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
/*delete confirmation popup */
function confirmDelete(userId) {
    var confirmDelete = confirm("Are you sure you want to delete this item?");
    
    if (confirmDelete) {
        // If the user clicks "OK" in the confirmation dialog, redirect to the delete URL
        window.location.href = 'welcome.php?delete_id=' + userId;
    }
}