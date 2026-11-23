$(document).ready(function () {
    loadTable();
});


function loadTable() {
    $.get("php/api/get_full_table.php", function (res) {
        var tbody = $("#inventoryTableBody");
        tbody.empty();

        if (res.status === 1 && res.data.length > 0) {
            $.each(res.data, function (index, table) {
                var row = `
                    <tr>
                        <td>${table.id }</td>
                        <td>${table.sku }</td>
                        <td>${table.name}</td>
                        <td>${table.description}</td>
                        <td>${table.unit_price}</td>
                        <td>${table.quantity}</td>
                        <td>${table.min_stock_threshold}</td>
                        <td>${table.image_path}</td>
                        <td>${table.category_id}</td>
                        <td>${table.category_name}</td>
                        <td>${table.updated_at}</td>
                        <td class="text-end">
                         <button type="button" class="btn btn-sm btn-outline-danger btn-delete" data-id="${table.id}" title ="Delete Product">
                                    <i class="bi bi-trash3-fill"></i>
                                </button>
                                </td>
                    </tr>
                `;

                tbody.append(row);
            });
        } else {
            tbody.html(
                '<tr><td colspan="12" class="text-center py-4 text-muted">No products found.</td></tr>'
            );
        }
    }, "json").fail(function () {
        $("#inventoryTableBody").html(
            '<tr><td colspan="12" class="text-center py-4 text-danger">Could not load products.</td></tr>'
        );
    });
}


$("#formAddProduct").on("submit", function (e) {
    e.preventDefault();
 
    var formData = {
        sku: $("#productSku").val(),
        name: $("#productName").val(),
        description: $("#productDescription").val(),
        unit_price: $("#unitPrice").val(),
        quantity: $("#productQuantity").val(),
        min_stock_threshold: $("#minimumStock").val(),
        image_path: $("#productImagePath").val(),
        category_id: $("#productCategoryId").val()
    };

    $.post("php/api/add_product.php", formData, function (response) {
        if (response.status === "success") {
            $("#formAddProduct")[0].reset();

            var modal = bootstrap.Modal.getInstance(document.getElementById("modalAddProduct"));
            if (modal) {
                modal.hide();
            }

            loadTable();
        } else {
            alert(response.message || "Could not add the product.");
        }
    }, "json").fail(function (xhr) {
        var message = xhr.responseJSON && xhr.responseJSON.message
            ? xhr.responseJSON.message
            : "Could not add the product.";
        alert(message);
    });
});

$(document).on("click", ".btn-delete", function () {
    var productId = $(this).data("id");

    if (!confirm("Are you sure you want to delete this product?")) {
        return;
    }

    $.post("php/api/delete_product.php", { id: productId }, function (response) {
        if (response.status === "success") {
            loadTable();
        } else {
            alert(response.message || "Could not delete the product.");
        }
    }, "json").fail(function (xhr) {
        var message = xhr.responseJSON && xhr.responseJSON.message
            ? xhr.responseJSON.message
            : "Could not delete the product.";
        alert(message);
    });
});