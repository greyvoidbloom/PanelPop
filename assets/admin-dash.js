$(document).ready(function() {
    // Add Product
    $('#addProductForm').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: 'add_product.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                $('#statusMessage').text('Product added successfully!').show();
                $('#addProductForm')[0].reset(); // Reset form fields
                setTimeout(function() {
                    $('#statusMessage').fadeOut();
                }, 2000); // Hide the status message after 2 seconds
                loadProducts(); // Reload the product list
            },
            error: function() {
                $('#statusMessage').text('Failed to add product.').show().css('background-color', '#f2dede').css('color', '#a94442');
            }
        });
    });

    // Edit Product
    $('#productList').on('click', '.edit-btn', function() {
        var row = $(this).closest('tr');
        var productId = row.data('id');
        var name = row.find('.product-name').text();
        var description = row.find('.product-description').text();
        var price = row.find('.product-price').text();

        $('#name').val(name);
        $('#description').val(description);
        $('#price').val(price);

        // Change form to update mode
        $('#addProductForm').off('submit').on('submit', function(e) {
            e.preventDefault();

            var updatedData = new FormData(this);
            updatedData.append('id', productId); // Add product ID for editing

            $.ajax({
                url: 'edit_product.php',
                type: 'POST',
                data: updatedData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#statusMessage').text('Product updated successfully!').show();
                    $('#addProductForm')[0].reset(); // Reset form fields
                    setTimeout(function() {
                        $('#statusMessage').fadeOut();
                    }, 5000); // Hide the status message after 5 seconds
                    loadProducts(); // Reload the product list
                },
                error: function() {
                    $('#statusMessage').text('Failed to update product.').show().css('background-color', '#f2dede').css('color', '#a94442');
                }
            });
        });
    });

    // Delete Product
    $('#productList').on('click', '.delete-btn', function() {
        var row = $(this).closest('tr');
        var productId = row.data('id');

        if (confirm('Are you sure you want to delete this product?')) {
            $.ajax({
                url: 'delete_product.php',
                type: 'POST',
                data: { id: productId },
                success: function(response) {
                    row.remove(); // Remove the row from the table
                    $('#statusMessage').text('Product deleted successfully!').show();
                    setTimeout(function() {
                        $('#statusMessage').fadeOut();
                    }, 5000); // Hide the status message after 5 seconds
                },
                error: function() {
                    $('#statusMessage').text('Failed to delete product.').show().css('background-color', '#f2dede').css('color', '#a94442');
                }
            });
        }
    });

    // Load Products (AJAX)
    function loadProducts() {
        $.ajax({
            url: 'view_products.php',
            method: 'GET',
            success: function(response) {
                $('#productList tbody').html(response);
            }
        });
    }

    loadProducts(); // Initially load products
});
