/*use for Edit button This part listens for a click event on elements with the class edit-id */
$(document).ready(function() {
    // Attach click event to the button
    $('.edit-id').on('click', function() {
        // Get data attributes
        var id = $(this).data('id');
        
        // Send AJAX request to check if email already exists
        $.ajax({
            url: './edit.php', // Replace with the actual path to your PHP script
            type: 'GET',
            data: { id: id },
            dataType: 'json',
            success: function(response) {
                // Check if the email already exists
                if (response.$check_email_result) {
                    alert('Email already exists. Please choose a different email.');
                } else {
                    // Proceed with fetching data if email doesn't exist
                    fetchData(id);
                }
            },
            error: function(xhr, status, error) {
                // Handle AJAX errors if needed
                console.error(xhr.responseText);
            }
        });
    });
/*use for edit Updates the form fields with the fetched data and shows the modal */
    function fetchData(id) {

        // Send AJAX request to fetch data from the server
        $.ajax({
            url: './edit.php', // Replace with the actual path to your PHP script
            type: 'GET',
            data: { id: id },
            dataType: 'json',
            success: function(response) {
                // Check if the request was successful
                console.log(response);
                if (response.success) {
                    console.log(response.data.id);
                    $('#update-id').val(id);
                    $('#update-name').val(response.data.name);
                    $('#update-email').val(response.data.email);
                    $('#update-number').val(response.data.number);

                    // Show the modal
                    $("#update_email_msg").text('');
                    $("#update_email_msg").text('');
                    $('#exampleModal1').modal('show');
                } else {
                    // Handle errors if needed
                    alert('Error');
                }
            },
            error: function(xhr, status, error) {
                // Handle AJAX errors if needed
                console.error(xhr.responseText);
            }
        });
    }
});
/*edit update and showing error popup The success callback handles the response from the server. If the update is successful (res.success is true), it hides the modal. If there is an error, it displays the error message in the #update_email_msg element. */

$("#update_submit").on("click",function(){

    $.ajax({
        url: './edit.php', // Replace with the actual path to your PHP script
        type: 'POST',
        data: { id: $("#update-id").val(),name :$("#update-name").val(),email:$("#update-email").val(),number:$("#update-number").val(),'op':'update' },
        // dataType: 'json',
        success: function(response) {
            res = JSON.parse(response);
            console.log(res.success);
            // Check if the request was successful
            if (res.success) {
                $('#exampleModal1').modal('hide');
            } else {
                $("#update_email_msg").text(res.message);
            }
        },
        error: function(xhr, status, error) {
            // Handle AJAX errors if needed
            console.error(xhr.responseText);
        }
    });
})
/*add popup The success callback handles the response from the server. If the insertion is successful (res.success is true), it hides the modal. If there is an error, it displays error messages in the respective elements (#add_name_msg, #add_email_msg, #add_number_msg).*/

$("#add_submit").on("click",function(){

    $.ajax({
        url: './insert.php', // Replace with the actual path to your PHP script
        type: 'POST',
        data: {name :$("#recipient-name").val(),email:$("#recipient-email").val(),number:$("#recipient-number").val(),'op':'insert' },
        // dataType: 'json',
        success: function(result) {
            res = JSON.parse(result);
            console.log(res);
            // Check if the request was successful
            if (res.success) {
                $('#exampleModal').modal('hide');
                getData();
            } else {

                $("#add_name_msg").empty();
                $("#add_email_msg").empty();
                $("#add_number_msg").empty();


                $.each(res.messages, function (index, message) {
                    if (message.field === 'name') {
                        $("#add_name_msg").text(message.error);
                    } else if (message.field === 'email') {
                        $("#add_email_msg").text(message.error);
                    } else if (message.field === 'number') {
                        $("#add_number_msg").text(message.error);
                    }
                });

            }
        }
        
    });
})

/*delete confirmation popup */
$(document).ready(function() {
    // Attach click event to the delete button
    $('.delete-id').on('click', function() {
  
        // Perform your delete logic here
        var id = $(this).data('id');
        $.ajax({
            url: './delete.php', 
            type: 'POST',
            data: {
                id: id,
                delete_submit: true 
            },
            // dataType: 'json',
            success: function(response) {
                console.log(response);
                $('#exampleModal2').modal('show');
            },
           
        });
    });
});

getData();
// console.log(getData);
function getData() {
    $.ajax({
        url: './display.php',
        type: 'GET',
        dataType: 'html',
        success: function (response) {
            console.log(response);
        
             if (response.success) {
                $('#tabledata').html(response);
            
            } else {
                // console.error(response.message);
            }
        },
        
    });
   
}


// function confirmDelete(userId) {
//     var confirmDelete = confirm("Are you sure you want to delete this item?");
    
//     if (confirmDelete) {
//         // If the user clicks "OK" in the confirmation dialog, redirect to the delete URL
//         window.location.href = 'welcome.php?delete_id=' + userId;
//     }
// }