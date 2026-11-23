window.addEventListener("auth", function (){
    let json = JSON.parse(session_details);
    $("#profile_name").html(json.full_name);
});

$(document).ready(function () {
    count_products();
    get_products();
});

function get_products() {
    // 1. Ask the PHP API for all products.
    $.get("php/api/get_products.php", function (response) {
        if (response.status !== 1) {
            console.error(response.message || "Could not load products.");
            return;
        }

        const products = response.data;

        // 2. Count the products using simple if statements.
        let lowStock = 0;
        let active = 0;
        let unconfirmed = 0;

        for (let i = 0; i < products.length; i++) {
            const quantity = Number(products[i].quantity);
            const minimum = Number(products[i].min_stock_threshold);

            if (quantity <= minimum) {
                lowStock++;
            }

            if (quantity > 0) {
                active++;
            } else {
                unconfirmed++;
            }
        }

        // 3. Calculate the active percentage for the circle.
        const total = products.length;
        const activePercent = total > 0
            ? Math.round((active / total) * 100)
            : 0;

        // 4. Put the results in the HTML card.
        $("#low_stock_count").text(lowStock);
        $("#all_items_count").text(total);
        $("#unconfirmed_items_count").text(unconfirmed);
        $("#active_items_percent").text(activePercent + "%");
        $("#active_items_ring").css("--active-percent", activePercent);
        $("#active_items_ring").attr(
            "aria-label",
            active + " active items out of " + total
        );
    }, "json").fail(function (error) {
        console.error("Could not load products.", error);
    });
}

function count_products() {
    $.get("php/api/count_products.php", function (rsp) {
        if (rsp.success) {
            $("#count_products").text(rsp.data);
            $("#all_items_count").text(rsp.data);
        } else {
            console.error(rsp.message || "Could not load the product count.");
        }
    }, "json").fail(function (error) {
        console.error("Could not load the product count.", error);
    });
}