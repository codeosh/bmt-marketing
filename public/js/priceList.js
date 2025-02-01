//script to handle the click events for each list item. When the user clicks on a list item, an AJAX request will be sent to the controller to fetch the content and display it inside the #contentDisplay div.
var url = "{{ route('admin-priceList.show', ['id' => '']) }}"; // Prepare the base URL with placeholder for ID
    // jQuery for simplicity ani-a
    $(document).ready(function() {
        // On click event for both bulletin and template list items
        $('li[data-type="bulletin"], li[data-type="template"]').on('click', function() {
        var id = $(this).data('id'); // Get the id of the clicked item
        var url = "{{ route('admin-priceList.show', ':id') }}".replace(':id', id); // Replace :id with the actual ID

        // Make an AJAX request
        $.ajax({
            url: url, // Using the dynamically generated URL
            method: 'GET',
            success: function(response) {
                $('#contentDisplay').html(response.content); // Display the content in the content area
            },
            error: function() {
                $('#contentDisplay').html('<p>Error loading content. Please try again.</p>');
            }
        });
    });
    });

