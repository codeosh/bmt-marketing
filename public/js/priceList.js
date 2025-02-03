//to fetch the specific list content then display on the content div
    $(document).ready(function() {
    $('li[data-type="bulletin"], li[data-type="template"]').on('click', function() {
        var id = $(this).data('id'); // Get the clicked item's ID

        var url = "/admin-priceList/" + id; // Use correct RESTful URL

        $.ajax({
            url: url,
            method: 'GET',
            dataType: 'json', // Ensure JSON response is expected
            success: function(response) {
                $('#contentDisplay').html(response.content); // Display the content
                $('#contentName').html(response.pname); // Display the panme
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", status, error);
                $('#contentDisplay').html('<p>Error loading content. Please try again.</p>');
            }
        });
    });
});

